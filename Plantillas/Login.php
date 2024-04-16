<?php
require 'Assets/Bases de datos/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $correo = $_POST['txtcorreo'];
    $contraseña = $_POST['txtcontraseña'];

    // Buscar el usuario en la base de datos por su correo electrónico
    $sql = "SELECT id_usuario, contraseña, id_rol FROM usuarios WHERE correo = '$correo'";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0) {
        // Si se encontró el usuario, verificar la contraseña
        $fila = $resultado->fetch_assoc();
        if (password_verify($contraseña, $fila['contraseña'])) {
            // Las credenciales son válidas, iniciar sesión estableciendo una variable de sesión
            session_start();
            $_SESSION['id_usuario'] = $fila['id_usuario'];

            // Verificar el id_rol del usuario
            if ($fila['id_rol'] == 3) {
                // Si el id_rol es 3, redirigir al usuario a la página "Mi cuenta.php" en la carpeta "Administrador"
                header("Location: Administrador/Gestion de mangas.php");
            } else {
                // Si el id_rol no es 3, redirigir al usuario a la página "Mi cuenta.php" en la carpeta "Usuario"
                header("Location: Usuario/Mi%20cuenta.php");
            }
            exit(); // Importante: detener la ejecución del script después de redirigir al usuario
        } else {
            // Contraseña incorrecta
            echo "Contraseña incorrecta";
        }
    } else {
        // Usuario no encontrado
        echo "Usuario no encontrado";
    }
}
?>

<html>


<body>

    <!-- Aquí comienza la estructura del Formulario de Login -->
    <form method="post">
        <i class="fas fa-gem me-3"></i><label class="form-label mt-4 mb-3">Inicio de sesión</label>

        <div class="form-floating mb-3">
            <input type="email" class="form-control" id="floatingEmail" name="txtcorreo" placeholder="nombre@ejemplo.com">
            <label>Correo electronico</label>
        </div>

        <div class="form-floating mb-3">
            <input type="password" class="form-control" id="floatingPassword" name="txtcontraseña" placeholder="Ingrese su contraseña" autocomplete="off">
            <label>Contraseña</label>
        </div>


        <button type="submit" class="btn btn-outline-primary">Iniciar sesión</button>

    </form>

</body>

</html>