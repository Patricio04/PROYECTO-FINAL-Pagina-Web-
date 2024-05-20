<?php
include 'Assets/Bases de datos/db.php';
if (session_start()=== true) {
    session_destroy();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["formulario"] == "signup") { // REGISTRO //

     
    $nombre = $_POST['TxtNombre'];
    $apellido = $_POST['TxtApellido'];
    $correo = $_POST['TxtCorreo'];
    $contraseña = $_POST['TxtContraseña'];

    $contraseña_encriptada = password_hash($contraseña, PASSWORD_DEFAULT);

    // IMPORTANTE: IdRol e IdPlan se establecen por defecto con esos valores ya que son los que corresponden a un plan no premium y un rol de no admin. (IdRol:1 = usuario, IdPlan: 1 = basico/gratuito)
    $sql = "INSERT INTO Usuario (Nombre, Apellido, Correo, IdRol, IdPlan, Contraseña) 
        VALUES ('$nombre', '$apellido', '$correo', 1, 1, '$contraseña_encriptada')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-dismissible alert-success' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 1500;'>
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
        <strong>Registro realizado correctamente!</strong></div>";
    } else {
        echo "<div class='alert alert-dismissible alert-danger' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 1500;'>
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
        <strong>Error al registrar</strong>, ese correo ya se encuentra en uso</div>";
    }


    } elseif ($_POST["formulario"] == "login") { // INICIO DE SESION //
        
    $correo = $_POST['txtcorreo'];
    $contraseña = $_POST['txtcontraseña'];

    // Buscar el usuario en la base de datos por su correo electrónico
    $sql = "SELECT IdUsuario, Contraseña, IdRol FROM Usuario WHERE Correo = '$correo'";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0) {
        // Si se encontró el usuario, verificar la contraseña
        $fila = $resultado->fetch_assoc();
        if (password_verify($contraseña, $fila['Contraseña'])) {
            // Las credenciales son válidas, establecer una variable de sesión
            session_start();
            $_SESSION['IdUsuario'] = $fila['IdUsuario'];

            // Verificar el id_rol del usuario y redirigirlo
            if ($fila['IdRol'] == 2) {
                header("Location: Administrador/Gestion-de-mangas.php");
            } else {
                header("Location: Usuario/biblioteca.php");
            }
            exit();
        } else {
          
            echo '<div class="custom-alert">
                    <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
                    Contraseña incorrecta
                  </div>';
        }
    } else {
        echo "Usuario no encontrado";
    }


    }
}

?>


 <BR></BR>
<br>
    <!-- Aquí comienza la estructura del Formulario de Login -->
    <div class="containerr" id="containerr">
        <div class="form-container sign-up">
        <form method="post">
                <h1>Create Account</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
                <input type="text" placeholder="Nombre(s)" name="TxtNombre">
                <input type="text" placeholder="Apellido(s)" name="TxtApellido">
                <input type="email" placeholder="Correo" name="TxtCorreo">
                <input type="password" placeholder="Contraseña" name="TxtContraseña">

                <input type="hidden" name="formulario" value="signup"> <!-- Este no se muestra, pero sirve para hacer la comprobacion de que formulario es el que se está enviando-->
            
                <button>Sign In</button>
            </form>
        </div>
        <div class="form-container sign-in">
        <form method="post">
                <h1>Iniciar Sesión</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
                <label>Correo electronico</label>
                <input type="email" class="form-control" id="floatingEmail" name="txtcorreo" placeholder="nombre@ejemplo.com">
            <label>Contraseña</label>
            <input type="password" class="form-control" id="floatingPassword" name="txtcontraseña" placeholder="Ingrese su contraseña" autocomplete="off">

            <input type="hidden" name="formulario" value="login"><!-- Este no se muestra, pero sirve para hacer la comprobacion de que formulario es el que se está enviando-->
         
            <button type="submit" class="btn btn-outline-primary">Enviar</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1>
                    <p>Ya tienes cuenta?inicia seccion para disfrutar la lectura de distintos mangas💜</p>
                    <button class="hidden" id="login">Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Hello, Friend!</h1>
                    <p>Aun no tienes cuenta?Que esperas registrese en este preciso instante!!</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>



    

