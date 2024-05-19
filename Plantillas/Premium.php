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
$sql = "SELECT * FROM `planes`";
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
    <strong>No se encontaron planes disponibles!</strong> Contacte con el administrador.</div>";
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

.front, .back {
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
    background-color: #28a745; /* Color de fondo verde */
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


</style>



<div id="paymentModal" class="modal">
    <div class="modal-content">
        <span class="close-btn">&times;</span>
        <div class="card-container">
            <div id="frontCard" class="card front">
                <div class="input-container">
                    <i class="fas fa-credit-card input-icon"></i>
                    <input type="text" id="cardNumber" maxlength="16" placeholder="Número de Tarjeta">
                </div>
                <div class="input-container">
                    <i class="far fa-user input-icon"></i>
                    <input type="text" id="cardHolder" placeholder="Nombre en la Tarjeta">
                </div>
                <div class="input-container">
                    <i class="fas fa-calendar-alt input-icon"></i>
                    <input type="text" id="expiryDate" maxlength="5" placeholder="Fecha de Expiración (MM/AA)">
                </div>
            </div>
            <div id="backCard" class="card back">
            
                <div class="input-container">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="text" id="cvv" maxlength="3" placeholder="CVV">
                </div>
            </div>
        </div>
        <button id="payBtn">Pagar</button>
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

                <button  id="openModalBtn" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#PagoModal">
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
    const openModalBtn = document.getElementById('openModalBtn');
    const closeModalBtn = document.querySelector('.close-btn');
    const cardContainer = document.querySelector('.card-container');
    
    openModalBtn.addEventListener('click', function() {
        modal.style.display = 'flex';
    });
    
    closeModalBtn.addEventListener('click', function() {
        modal.style.display = 'none';
    });
    
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
    
    cardContainer.addEventListener('dblclick', function() {
        cardContainer.classList.toggle('double-clicked');
    });
});

</script>

<?php
include '../Plantillas/Footer.php';
?>
