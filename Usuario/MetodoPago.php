<!DOCTYPE html>
<html lang="en">
<!--
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tatsu</title>

    <link rel="Stylesheet" href="../Styles/bootstrap.min.css" />
    <link rel="Stylesheet" href="../Styles/normalize.css" />
    <link rel="Stylesheet" href="../Styles/index.css" />
    <link rel="Stylesheet" href="../Styles/Mi cuenta.css" />


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Honk&family=Rubik+Glitch+Pop&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Rubik+Glitch+Pop&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Silkscreen:wght@400;700&display=swap" rel="stylesheet">

</head>
-->
<?php include '../Plantillas/Header.php';
require '../Assets/Bases de datos/db.php';


//Consultar la base de datos para obtener los datos del usuario usando el ID de usuario, se trae todos los datos del usuario segun su ID y los almacena en la variable $datos_usuario para luego ser utilizada para llamar a un registro en especifico como el siguiente: echo $datos_usuario['correo']; que usa la variable para traer todos los datos y luego selecciona "correo" como unico dato por extraer y con echo se imprime dentro del formulario

$sql = "SELECT * FROM Tarjeta WHERE IdUsuario = $id_usuario";
$resultado = $conn->query($sql);

// Verificar si se encontraron datos de la tarjeta
if ($resultado->num_rows > 0) {
    // Obtener los datos de la tarjeta
    $datos_tarjeta = $resultado->fetch_assoc();
    $fechaVencimiento = date('Y-m', strtotime($datos_tarjeta['FechaVencimiento']));
} else {
    // No se encontraron datos de la tarjeta
    echo "";
}








if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $numeroTarjeta = $_POST['txtNumero'];
    $titularTarjeta = $_POST['txtTitular'];
    $fechaVencimiento = $_POST['mthFecha'] . "-01";
    $cvv = $_POST['txtCVV'];

    // Consulta para verificar si ya existe una tarjeta para el usuario
    $sql_count = "SELECT COUNT(*) AS count FROM Tarjeta WHERE IdUsuario = $id_usuario";
    $resultado_count = $conn->query($sql_count);
    $count = $resultado_count->fetch_assoc()['count'];

    if ($count > 0) {
        // Si existe una tarjeta, realizar un UPDATE
        $sql_update = "UPDATE Tarjeta SET 
                       NumeroTarjeta = '$numeroTarjeta', 
                       TitularTarjeta = '$titularTarjeta', 
                       FechaVencimiento = '$fechaVencimiento', 
                       CVV = '$cvv' 
                       WHERE IdUsuario = $id_usuario";
        if ($conn->query($sql_update) === TRUE) {
            echo "<div class='alert alert-dismissible alert-info' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 1000;'>
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            <strong>Cambios realizados correctamente</strong>
          </div>";
        } else {
            echo "<div class='alert alert-dismissible alert-warning' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 1000;'>
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            <strong>UPS! algo salió mal</strong>
          </div>" . $conn->error;
        }
    } else {
        // Si no existe una tarjeta, realizar un INSERT
        $sql_insert = "INSERT INTO Tarjeta (IdUsuario, NumeroTarjeta, TitularTarjeta, FechaVencimiento, CVV) VALUES 
                       ($id_usuario, '$numeroTarjeta', '$titularTarjeta', '$fechaVencimiento', '$cvv')";
        if ($conn->query($sql_insert) === TRUE) {
            echo "<div class='alert alert-dismissible alert-info' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 1000;'>
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            <strong>Informacion de pago guardada correctamente</strong>
          </div>";
        } else {
            echo "<div class='alert alert-dismissible alert-warning' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 1000;'>
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
            <strong>Ups!, algo salió mal</strong>
          </div>" . $conn->error;
        }
    }
}

$conn->close();

if (isset($_GET['cerrar_sesion'])) {
    // Destruir todas las variables de sesión
    session_unset();

    // Destruir la sesión
    session_destroy();

    header("Location: ../index.php");
    exit();
}



?>

<style>
    .list-group-item {
        transition: filter 0.3s ease;
        /* Añadir una transición suave */
    }

    .list-group-item:hover {
        filter: brightness(1.3);
        /* Aumentar el brillo al pasar el ratón */
    }
</style>

<body>
    <div class="container mt-4">
        <div class="row bg-dark p-4">
            <div class="col-lg-4">
                <ul class="list-group">
                    <li class="list-group-item">
                        <a class="nav-link" href="<?php echo $url . '/Usuario/Mi cuenta.php'; ?>">Mi cuenta</a>
                    </li>
                    <li class="list-group-item active">
                        <a class="nav-link" href="<?php echo $url . '/Usuario/MetodoPago.php'; ?>">Metodo de pago</a>
                    </li>
                    <li class="list-group-item">
                        <a class="nav-link" href="?cerrar_sesion">Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
            <fieldset class="col-lg-8">
                <form method="post">
                    <i class="fas fa-gem me-3"></i><label class="form-label mb-3">Informacion de metodo de pago</label>
                    <input type="text" hidden value="<?php echo $id_usuario; ?>">

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingname" name="txtNumero" value="<?php echo isset($datos_tarjeta['NumeroTarjeta']) ? $datos_tarjeta['NumeroTarjeta'] : ''; ?>" disabled>
                        <label>Numero de la tarjeta</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingLastname" name="txtTitular" value="<?php echo isset($datos_tarjeta['TitularTarjeta']) ? $datos_tarjeta['TitularTarjeta'] : ''; ?>" disabled>
                        <label>Titular en la tarjeta</label>
                    </div>
                    <div class="form-floating mb-3 ">
                        <input type="month" class="form-control" id="floatingEmail" name="mthFecha" value="<?php echo isset($fechaVencimiento) ? $fechaVencimiento : ''; ?>" disabled>
                        <label>Fecha de vencimiento</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingPassword" name="txtCVV" placeholder="Password" autocomplete="off" disabled value="<?php echo isset($datos_tarjeta['CVV']) ? $datos_tarjeta['CVV'] : ''; ?>">
                        <label for="floatingPassword">CVV</label>
                    </div>
                    <button type="submit" class="btn btn-outline-primary" name="btnmodificar" id="btnmodificar" value="modificar">Modificar datos</button>
                    <button type="submit" class="btn btn-outline-primary" name="btnguardar" value="guardar">Guardar cambios</button>
                </form>
            </fieldset>
        </div>
    </div>
    <?php include '../Plantillas/Footer.php'; ?>
    <?php echo ob_get_clean(); ?>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../Scrips/Mi cuenta.js"></script>
</body>