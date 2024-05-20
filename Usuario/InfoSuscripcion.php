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

if (isset($_GET['cerrar_sesion'])) {
    // Destruir todas las variables de sesión
    session_unset();

    // Destruir la sesión
    session_destroy();

    header("Location: ../index.php");
    exit();
}
//Consultar la base de datos para obtener los datos del usuario usando el ID de usuario, se trae todos los datos del usuario segun su ID y los almacena en la variable $datos_usuario para luego ser utilizada para llamar a un registro en especifico como el siguiente: echo $datos_usuario['correo']; que usa la variable para traer todos los datos y luego selecciona "correo" como unico dato por extraer y con echo se imprime dentro del formulario

$sql = "SELECT * FROM suscripcion WHERE IdUsuario = $id_usuario AND Activa = 1";
$resultado = $conn->query($sql);

// Verificar si se encontraron datos de la suscripción
if ($resultado->num_rows > 0) {
    // Obtener los datos de la suscripción
    $datos_suscripcion = $resultado->fetch_assoc();

    // Consulta para obtener el plan basado en el ID del plan de la suscripción
    $sql_plan = "SELECT * FROM planes WHERE IdPlan = ?";
    $stmt_plan = $conn->prepare($sql_plan);

    if ($stmt_plan === false) {
        die('Error al preparar la consulta: ' . $conn->error);
    }

    // Asignar el valor al marcador de posición utilizando bind_param
    $id_plan = $datos_suscripcion['IdPlan'];
    $stmt_plan->bind_param("i", $id_plan);

    // Ejecutar la consulta preparada
    $stmt_plan->execute();
    $resultado_plan = $stmt_plan->get_result();

    // Verificar si se encontraron datos del plan
    if ($resultado_plan->num_rows > 0) {
        // Obtener los datos del plan
        $datos_plan = $resultado_plan->fetch_assoc();
        
        // Aquí puedes mostrar los detalles del plan
        // Por ejemplo:
        
    } else {
        // No se encontraron datos del plan
        echo "";
    }
} else {
    // No se encontraron datos de la suscripción
    echo "";
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
                    <li class="list-group-item">
                        <a class="nav-link" href="<?php echo $url . '/Usuario/MetodoPago.php'; ?>">Metodo de pago</a>
                    </li>
                    <li class="list-group-item active">
                        <a class="nav-link" href="<?php echo $url . '/Usuario/InfoSuscripcion.php'; ?>">Suscripciones</a>
                    </li>
                    <li class="list-group-item">
                        <a class="nav-link" href="?cerrar_sesion">Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
            <fieldset class="col-lg-8">
                <form method="post">
                    <i class="fas fa-gem me-3"></i><label class="form-label mb-3">Informacion de suscripcion</label>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingname" name="txtNumero" value="<?php echo isset($datos_plan['TituloPlan']) ? $datos_plan['TituloPlan'] : ''; ?>" readonly>
                        <label>Plan contratado:</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingLastname" name="txtTitular" value="<?php echo isset($datos_suscripcion['FechaInicio']) ? $datos_suscripcion['FechaInicio'] : ''; ?>" readonly>
                        <label>Fecha de inicio de suscripcion</label>
                    </div>
                    <div class="form-floating mb-3 ">
                        <input type="text" class="form-control" id="floatingEmail" name="mthFecha" value="<?php echo isset($datos_suscripcion['FechaFin']) ? $datos_suscripcion['FechaFin'] : ''; ?>" readonly>
                        <label>Fecha de vencimiento de suscripcion</label>
                    </div>

                    <!-- Otros campos que quieras mostrar de la suscripción -->

                </form>
            </fieldset>



        </div>
    </div>
    <?php include '../Plantillas/Footer.php'; ?>
    <?php echo ob_get_clean(); ?>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../Scrips/Mi cuenta.js"></script>
</body>