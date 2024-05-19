<?php
include '../Assets/Bases de datos/db.php';
include './Header.php';


/*
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($_POST['id_plan'] == 2) {
        
        header("Location: ./MetodoPago.php");
        exit(); 

    }   else {
        echo "<div class='alert alert-dismissible alert-info' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 1000;'>
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
        <strong>Ya cuentas con este plan activo!</strong> Te invitamos a pasarte a premium :D</div>";
    }
}
*/
$sql = "SELECT * FROM `planes` WHERE `Activo` = 1";
$resultado = $conn->query($sql);

// Verificar si se encontraron resultados
if ($resultado->num_rows > 0) {
    // Array para almacenar los planes
    $planes = array();

    // Obtener los resultados y guardarlos en el array de planes
    while ($fila = $resultado->fetch_assoc()) {
        $planes[] = $fila;
    }

    // Liberar el resultado
    $resultado->free();
} else {
    // No se encontraron resultados
    echo "<div class='alert alert-dismissible alert-warning' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 1000;'>
    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
    <strong>No se encontraron planes disponibles!</strong> Contacte con el administrador.</div>";
}

$sql = "SELECT * FROM Planes ";
$resultado = $conn->query($sql);

// Verificar si se encontraron datos del usuario y del plan
if ($resultado->num_rows > 0) {

    $datos_planes = $resultado->fetch_assoc();
} else {

    echo "<div class='alert alert-dismissible alert-warning' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 1000;'>
    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
    <strong>No se encontraron datos de los planes</strong></div>";
}

$sql = "SELECT * FROM Tarjeta WHERE IdUsuario = $id_usuario";
$resultado = $conn->query($sql);

// Verificar si se encontraron resultados
if ($resultado->num_rows > 0) {
    // Obtener los resultados y guardarlos en un array
    $datos_tarjeta = $resultado->fetch_assoc();

    // Convertir FechaVencimiento al formato YYYY-MM
    $fechaVencimiento = date('Y-m', strtotime($datos_tarjeta['FechaVencimiento']));

    // Liberar el resultado
    $resultado->free();
} else {
    // No se encontraron resultados
    echo "";
}

$sql = "SELECT * FROM MetodoPago";
$resultado = $conn->query($sql);

$MetodosDePago = array();
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $MetodosDePago[] = array(
            "IdMetodoPago" => $fila["IdMetodoPago"],
            "TipoDePago" => $fila["TipoDePago"]
        );
    }
} else {
    echo "";
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Establecer la zona horaria
    date_default_timezone_set('America/Mexico_City');

    // Obtener los datos del formulario
    $metodopago = $_POST['selectMetodoPago'];
    $usuarioID = $_POST['txtIdUsuario'];
    $planID = $_POST['txtIDPlan'];

    // Obtener el precio del plan
    
    $sql = "SELECT PrecioPlan FROM planes WHERE IdPlan = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Error preparando la consulta de selección de precio del plan: " . $conn->error);
    }
    $stmt->bind_param("i", $planID);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        throw new Exception("No se encontró el precio del plan con IdPlan: $planID");
    }
    $precioPlan = $row['PrecioPlan'];
    

    // Verificar que el precio del plan no sea 0.00
    if ($precioPlan == 0.00) {
        
        header('Location: Premium.php');
        echo "<div class='alert alert-dismissible alert-warning' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 1000;'>
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
        <strong>No puedes suscribirte a un plan gratuito. Por favor, selecciona un plan válido.</strong></div>";
        exit; // Detener la ejecución del script
    }

    // Calcular la fecha de inicio (actual)
    $fechaInicio = date('Y-m-d H:i:s'); // Fecha y hora actuales

    // Calcular la fecha de fin (1 mes después de la fecha de inicio)
    $fechaFin = date('Y-m-d H:i:s', strtotime('+1 month', strtotime($fechaInicio)));

    // Iniciar la transacción
    $conn->begin_transaction();

    try {
        // Verificar si ya existe una suscripción activa
        $sql = "SELECT COUNT(*) as count FROM suscripcion WHERE IdUsuario = ? AND Activa = 1";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error preparando la consulta de verificación: " . $conn->error);
        }
        $stmt->bind_param("i", $usuarioID);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row['count'] == 0) {
            

            // Insertar datos en la tabla de suscripciones
            $sql = "INSERT INTO suscripcion (IdUsuario, IdPlan, FechaInicio, FechaFin, Activa)
                    VALUES (?, ?, ?, ?, 1)";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Error preparando la consulta de inserción en suscripción: " . $conn->error);
            }
            $stmt->bind_param("iiss", $usuarioID, $planID, $fechaInicio, $fechaFin);
            if ($stmt->execute()) {
                
            } else {
                throw new Exception("Error ejecutando la inserción en suscripción: " . $stmt->error);
            }

            // Actualizar el ID del plan en la tabla de usuarios
            
            $sql = "UPDATE usuario SET IdPlan = ? WHERE IdUsuario = ?";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Error preparando la consulta de actualización de usuario: " . $conn->error);
            }
            $stmt->bind_param("ii", $planID, $usuarioID);
            if ($stmt->execute()) {
                
            } else {
                throw new Exception("Error ejecutando la actualización de usuario: " . $stmt->error);
            }

            // Insertar datos en la tabla de ventas de planes
            $sql = "INSERT INTO ventaplan (IdUsuario, IdPlan, PrecioPlan, IdMetodoPago)
                    VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Error preparando la consulta de inserción en ventaplan: " . $conn->error);
            }
            $stmt->bind_param("iidi", $usuarioID, $planID, $precioPlan, $metodopago);
            if ($stmt->execute()) {
                
            } else {
                throw new Exception("Error ejecutando la inserción en ventaplan: " . $stmt->error);
            }

            // Confirmar la transacción
            $conn->commit();
            echo "<div class='alert alert-dismissible alert-success' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 1000;'>
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            <strong>Gracias por suscribirte, ¡ahora perteneces a los miembros exclusivos de la página!</strong></div>";
        } else {
            echo "<div class='alert alert-dismissible alert-warning' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 1000;'>
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            <strong>Ya cuentas con una suscripción activa!! </strong></div>";
        }
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $conn->rollback();
        echo "<div class='alert alert-dismissible alert-warning' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 1000;'>
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
        <strong>Error al suscribirse: " . $e->getMessage() . "</strong></div>";
    }
}


?>



<style>
    body {
        font-family: Arial, sans-serif;
    }

    button {
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        cursor: pointer;
    }

    button:hover {
        background-color: #0056b3;
    }

    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background-color: white;
        padding: 40px;
        border-radius: 10px;
        width: 400px;
        position: relative;
    }

    .close-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 20px;
        cursor: pointer;
    }

    .card-container {
        perspective: 1000px;
    }

    .card {
        width: 100%;
        background-color: #2e2e2e;
        color: white;
        border-radius: 10px;
        padding: 20px;
        box-sizing: border-box;
        backface-visibility: hidden;
        transition: transform 0.6s;
        margin-bottom: 20px;
    }

    .front,
    .back {
        position: relative;
        display: flex;
        flex-direction: column;
    }

    label {
        margin-bottom: 10px;
    }

    .input-container {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .input-icon {
        margin-right: 10px;
    }

    input {
        flex: 1;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    button#payBtn {
        padding: 15px 40px;
        font-size: 18px;
        background-color: #28a745;
        /* Color de fondo verde */
    }

    .icon {
        font-size: 24px;
        color: #ccc;
    }

    .back {
        position: absolute;
        top: 0;
        left: 0;
        transform: rotateY(180deg);
        display: none;
    }

    .card-container.double-clicked .front {
        transform: rotateY(180deg);
    }

    .card-container.double-clicked .back {
        transform: rotateY(0);
        display: block;
    }

    .modal-visible {
        display: flex;
    }
</style>



<div id="paymentModal" class="modal">
    <div class="modal-content">
        <form method="POST">
            <span class="close-btn">&times;</span>
            <div class="card-container">
                <div id="frontCard" class="card front">
                    <div class="input-container">
                        <i class="fas fa-credit-card input-icon"></i>
                        <input type="text" id="cardNumber" maxlength="16" placeholder="Número de Tarjeta" value="<?php echo isset($datos_tarjeta['NumeroTarjeta']) ? $datos_tarjeta['NumeroTarjeta'] : ''; ?>" name="txtNumeroTarjeta">
                        <input type="text" id="cardNumber" maxlength="16" placeholder="Número de Tarjeta" value="<?php echo $id_usuario; ?>" name="txtIdUsuario" hidden>

                    </div>
                    <div class="input-container">
                        <i class="far fa-user input-icon"></i>
                        <input type="text" id="cardHolder" placeholder="Nombre en la Tarjeta" value="<?php echo isset($datos_tarjeta['TitularTarjeta']) ? $datos_tarjeta['TitularTarjeta'] : ''; ?>" name="txtTitularTarjeta" required>
                    </div>
                    <div class="input-container">
                        <i class="fas fa-calendar-alt input-icon"></i>
                        <input type="month" id="expiryDate" maxlength="5" placeholder="Fecha de Expiración (MM/AA)" value="<?php echo isset($fechaVencimiento) ? $fechaVencimiento : ''; ?>" name="mthFechaVencimiento" required>
                    </div>
                </div>
                <div id="backCard" class="card back">

                    <div class="input-container">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="text" id="cvv" maxlength="3" placeholder="CVV" value="<?php echo isset($datos_tarjeta['CVV']) ? $datos_tarjeta['CVV'] : ''; ?>" name="txtCVV" required>
                    </div>
                    <div class="input-container">
                        <i class="fas fa-lock input-icon"></i>
                        <select class="form-select" id="exampleSelect1" required name="selectMetodoPago">
                            <option selected disabled value="">Tipo de tarjeta</option>
                            <?php foreach ($MetodosDePago as $MetodoPago) { ?>
                                <option value="<?php echo $MetodoPago['IdMetodoPago']; ?>"><?php echo $MetodoPago['TipoDePago']; ?></option>
                            <?php } ?>

                        </select>
                    </div>
                    <div class="input-container">
                        <i class="fas fa-lock input-icon"></i>
                        <select class="form-select" name="txtIDPlan" id="selectPlan" required>
                            <option value="" disabled selected>Selecciona un plan</option>
                            <?php foreach ($planes as $plan) { ?>
                                <option value="<?php echo $plan['IdPlan']; ?>"><?php echo $plan['TituloPlan']; ?> - <?php echo $plan['PrecioPlan']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <button type="submit" id="payBtn">Pagar</button>
        </form>
    </div>
</div>




<!-- Apartado Premium -->
<div class="container">
    <div class="plan-container">
        <?php foreach ($planes as $plan) : ?>
            <div class="plan">
                <h3 class="animated-title"><?php echo $plan['TituloPlan']; ?></h3>
                <div class="cat-animation"></div> <!-- Aquí se inserta la animación del gatito -->
                <div class="price">$<?php echo $plan['PrecioPlan']; ?>/mes</div>
                <ul class="features">
                    <li><?php echo $plan['DescripcionPlan']; ?></li>
                </ul>

                <input type="hidden" class="id_plan" name="id_plan" value="<?php echo $plan['IdPlan']; ?>">

                <button type="submit" class="btn btn-success open-modal-btn" data-plan-id="<?php echo $plan['IdPlan']; ?>">
                    <i class="fa-solid fa-shopping-cart"></i>Suscribirse
                </button>


                <div class="btn-bg"></div>
            </div>
        <?php endforeach; ?>


    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('paymentModal');
        const openModalBtns = document.querySelectorAll('.open-modal-btn');
        const closeModalBtn = document.querySelector('.close-btn');
        const cardContainer = document.querySelector('.card-container');

        // Agregar evento de clic para abrir el modal
        openModalBtns.forEach(function(btn) {
            btn.addEventListener('click', function() {
                const planId = this.getAttribute('data-plan-id');
                if (planId !== '1') {
                    modal.classList.add('modal-visible');
                } else {
                    console.log('No se puede suscribir al plan con ID 1');
                }
            });
        });

        // Agregar evento de clic para cerrar el modal
        closeModalBtn.addEventListener('click', function() {
            modal.classList.remove('modal-visible');
        });

        // Agregar evento de clic para cerrar el modal al hacer clic fuera de él
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.classList.remove('modal-visible');
            }
        });

        // Agregar evento de doble clic para girar el modal
        cardContainer.addEventListener('dblclick', function() {
            cardContainer.classList.toggle('double-clicked');
        });
    });
</script>

<?php
include '../Plantillas/Footer.php';
?>