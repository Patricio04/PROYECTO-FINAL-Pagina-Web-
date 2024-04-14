<?php require 'Assets/Bases de datos/db.php';



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre = $_POST['txtnombre'];
    $apellido = $_POST['txtapellido'];
    $correo = $_POST['txtcorreo'];
    $contraseña = $_POST['txtcontraseña'];

    // Encriptar la contraseña
    $contraseña_encriptada = password_hash($contraseña, PASSWORD_DEFAULT);

    // Preparar la consulta SQL para insertar datos en la tabla, IMPORTANTE: id_rol e id_plan se establecen por defecto con esos valores ya que son los que corresponden a un plan no premium y un rol no premium. (id_rol:1 = basico, id_plan: 1 = basico)
    $sql = "INSERT INTO usuarios (nombre, apellido, correo, id_rol, id_plan, contraseña) 
        VALUES ('$nombre', '$apellido', '$correo', 1, 1, '$contraseña_encriptada')";
    // Ejecutar la consulta
    if ($conn->query($sql) === TRUE) {
        echo "Registro exitoso";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>



<html>


<body>

    <!-- Aquí comienza la estructura del Formulario de Registro -->
    <form method="post">
        <i class="fas fa-gem me-3"></i><label class="form-label mt-4 mb-3">Registro</label>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingFirstname" name="txtnombre"
                placeholder="Coloque su nombre, ej. 'Marco' ">
            <label>Nombres</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingLastname" name="txtapellido"
                placeholder="Coloque su apellido, ej. 'Aurelio' ">
            <label>Apellidos</label>
        </div>
        <div class="form-floating mb-3">
            <input type="email" class="form-control" id="floatingEmail" name="txtcorreo" placeholder="name@example.com">
            <label>Correo electronico</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" class="form-control" id="floatingPassword" name="txtcontraseña"
                placeholder="Password" autocomplete="off">
            <label>Contraseña</label>
        </div>
        <button type="submit" class="btn btn-outline-primary">Registrarse</button>

    </form>

</body>

</html>