<?php
require 'Assets/Bases de datos/db.php';

// Iniciar la sesión al principio del script


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
            // Las credenciales son válidas, establecer una variable de sesión
            session_start();
            $_SESSION['id_usuario'] = $fila['id_usuario'];

            // Verificar el id_rol del usuario y redirigirlo
            if ($fila['id_rol'] == 3) {
                header("Location: Administrador/Gestion de mangas.php");
            } else {
                header("Location: Usuario/Mi%20cuenta.php");
            }
            exit(); // Detener la ejecución del script después de redirigir
        } else {
          
            echo '<div class="custom-alert">
                    <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
                    Contraseña incorrecta
                  </div>';
        }
    } else {
        // Usuario no encontrado
        echo "Usuario no encontrado";
    }
}
?>
 <!-- Aquí comienza la estructura del Formulario de Login -->



    <!-- Aquí comienza la estructura del Formulario de Login -->
    <div class="containerr" id="containerr">
        <div class="form-container sign-up">
        <form >
                <h1>Create Account</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
                <span>or use your email for registeration</span>
                <input type="text" placeholder="Name">
                <input type="email" placeholder="Email">
                <input type="password" placeholder="Password">
                <a href="#">Forget Your Password?</a>
                <button>Sign In</button>
            </form>
        </div>
        <div class="form-container sign-in">
        <form method="post">
                <h1>Inicie Sesion</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
                <span>or use your email password</span>
                <label>Correo electronico</label>
                <input type="email" class="form-control" id="floatingEmail" name="txtcorreo" placeholder="nombre@ejemplo.com">
            <label>Contraseña</label>
            <input type="password" class="form-control" id="floatingPassword" name="txtcontraseña" placeholder="Ingrese su contraseña" autocomplete="off">
         
            <button type="submit" class="btn btn-outline-primary">Enviar</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1>
                    <p>Enter your personal details to use all of site features</p>
                    <button class="hidden" id="login">Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Hello, Friend!</h1>
                    <p>Register with your personal details to use all of site features</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>



    

