<!DOCTYPE html>
<html lang="en">

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
<?php include '../Plantillas/Header.php';
require '../Assets/Bases de datos/db.php';
?>
<?php
// Verificar si el usuario está autenticado

if (!isset($_SESSION['id_usuario'])) {
    // El usuario no ha iniciado sesión, redirigirlo a la página de inicio de sesión
    header("Location: ../Index.php");
    exit();
}

// Si el usuario está autenticado, obtener el ID de usuario de la sesión
$id_usuario = $_SESSION['id_usuario'];

//Consultar la base de datos para obtener los datos del usuario usando el ID de usuario, se trae todos los datos del usuario segun su ID y los almacena en la variable $datos_usuario para luego ser utilizada para llamar a un registro en especifico como el siguiente: echo $datos_usuario['correo']; que usa la variable para traer todos los datos y luego selecciona "correo" como unico dato por extraer y con echo se imprime dentro del formulario

$sql = "SELECT * FROM usuarios WHERE id_usuario = $id_usuario";
$resultado = $conn->query($sql);

// Verificar si se encontraron datos del usuario
if ($resultado->num_rows > 0) {
    // Obtener los datos del usuario como un array asociativo
    $datos_usuario = $resultado->fetch_assoc();
} else {
    // No se encontraron datos del usuario
    echo "No se encontraron datos del usuario";
}


?>

<?php
// Consulta SQL para obtener los datos del usuario y el nombre del plan
$sql = "SELECT usuarios.*, planes.titulo_plan AS nombre_plan
        FROM usuarios
        INNER JOIN planes ON usuarios.id_plan = planes.id_plan
        WHERE usuarios.id_usuario = $id_usuario";
$resultado = $conn->query($sql);

// Verificar si se encontraron datos del usuario y del plan
if ($resultado->num_rows > 0) {
    // Obtener los datos del usuario y del plan como un array asociativo
    $datos_usuario = $resultado->fetch_assoc();
} else {
    // No se encontraron datos del usuario y del plan
    echo "No se encontraron datos del usuario";
}

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar qué botón se ha presionado
    if (isset($_POST['btnguardar']) && $_POST['btnguardar'] == 'guardar') {
        // Obtener los valores actualizados del formulario
        $nombre = $_POST['txtnombre'];
        $apellido = $_POST['txtapellido'];
        $correo = $_POST['txtcorreo'];
        $contraseña = $_POST['txtcontraseña'];
        
        // Encriptar la contraseña
        $contraseña_encriptada = password_hash($contraseña, PASSWORD_DEFAULT);
        
        // Consulta SQL para actualizar los datos del usuario
        $sql = "UPDATE usuarios SET nombre='$nombre', apellido='$apellido', correo='$correo', contraseña='$contraseña_encriptada' WHERE id_usuario = $id_usuario";

        // Ejecutar la consulta
        if ($conn->query($sql) === TRUE) {
            echo "Los datos se actualizaron correctamente";
        } else {
            echo "Error al actualizar los datos: " . $conn->error;
        }
    }
}

// Cerrar la conexión a la base de datos
$conn->close();
?>

<?php


// Verificar si se ha hecho clic en el botón "Cerrar Sesión"
if (isset($_GET['cerrar_sesion'])) {
    // Destruir todas las variables de sesión
    session_unset();

    // Destruir la sesión
    session_destroy();

    // Redirigir al usuario a index.php
    header("Location: ../index.php");
    exit();
}
?>



<body>
    <div class="container mt-4">
        <div class="row bg-dark p-4">
            <div class="col-lg-4">
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item mb-2">
                        <a class="nav-link active" href="#">Mi cuenta</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link btn btn-outline-danger" href="?cerrar_sesion">Cerrar Sesión</a>
                    </li>
                    <ul />
            </div>
            <fieldset class="col-lg-8">
                <form method="post">
                    <i class="fas fa-gem me-3"></i><label class="form-label mb-3">Datos de usuario</label>
                    <div class="row">
                        <div class="form-floating mb-3 col-lg-6">
                            <input type="text" class="form-control" name="txtID" id="txtID" value="<?php echo $datos_usuario['id_usuario']; // el echo $datos_usuario['correo']; imprime dentro de los inputs los datos que se trae desde la BD?>" disabled> 
                            <label>ID</label>
                        </div>
                        <div class="form-floating mb-3 col-lg-6">
                            
                            <input type="text" class="form-control" name="txtPlan" id="txtPlan" value="<?php echo $datos_usuario['nombre_plan']; ?>" disabled>
                            <label>Plan</label>
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingname" name="txtnombre" value="<?php echo $datos_usuario['nombre']; ?>" disabled>
                        <label>Nombres</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingLastname" name="txtapellido" value="<?php echo $datos_usuario['apellido']; ?>" disabled>
                        <label>Apellidos</label>
                    </div>
                    <div class="form-floating mb-3 ">
                        <input type="email" class="form-control" id="floatingEmail" name="txtcorreo" value="<?php echo $datos_usuario['correo']; ?>" disabled>
                        <label>Correo electronico</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="floatingPassword" name="txtcontraseña" placeholder="Password" autocomplete="off" disabled value="<?php echo $datos_usuario['contraseña']; ?>">
                        <label for="floatingPassword">Contraseña</label>
                    </div>
                    <button type="submit" class="btn btn-outline-primary" name="btnmodificar" id="btnmodificar" value="modificar">Modificar datos</button>
                    <button type="submit" class="btn btn-outline-primary" name="btnguardar" value="guardar">Guardar cambios</button>
                </form>
            </fieldset>
        </div>
    </div>
    <?php include '../Plantillas/Footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../Scrips/Mi cuenta.js"></script>
</body>