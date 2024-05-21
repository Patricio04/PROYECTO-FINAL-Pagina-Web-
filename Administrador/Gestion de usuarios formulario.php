<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
    <link rel="stylesheet" href="../Styles/AdministradorCSS/Administrador.css">
    <link rel="stylesheet" href="../Styles/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


</head>

<?php
require '../Assets/Bases de datos/db.php';

$sql = "SELECT IdPlan, TituloPlan FROM Planes";
$resultado = $conn->query($sql);

$Planes = array();
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $Planes[] = array(
            "IdPlan" => $fila["IdPlan"],
            "TituloPlan" => $fila["TituloPlan"]
        );
    }
} else {
    echo "No se encontraron Planes.";
}

$sql = "SELECT IdRol, NombreRol FROM Rol";
$resultado = $conn->query($sql);

$Roles = array();
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $Roles[] = array(
            "IdRol" => $fila["IdRol"],
            "NombreRol" => $fila["NombreRol"]
        );
    }
} else {
    echo "No se encontraron Roles.";
}




if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST['txtnombre'];
    $apellido = $_POST['txtapellido'];
    $correo = $_POST['txtcorreo'];
    $contraseña = $_POST['txtcontraseña'];
    $rol = $_POST['selectrol'];
    $plan = $_POST['selectplan'];

    $contraseña_encriptada = password_hash($contraseña, PASSWORD_DEFAULT);


    $sql = "INSERT INTO Usuario (Nombre, Apellido, Correo, IdRol, IdPlan, Contraseña) VALUES ('$nombre', '$apellido', '$correo', '$rol', '$plan', '$contraseña_encriptada')";
    $result = $conn->query($sql);


    header("Location: Gestion de usuarios.php");
    exit();

    

}




?>



<body>

    <nav class="navbar bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand  link-light" href="./Gestion-de-mangas.php">
                <img src="../Img/noto-v1_tornado.png" alt="Tatsu logo">Tatsu </img>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <i class="fa-solid fa-gear m-1"></i>
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Administrador</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-book m-2"></i>Contenido
                            </a>
                            <ul class="dropdown-menu show">
                                <li><a class="dropdown-item" href="./Gestion-de-mangas.php"><i class="fa-solid fa-book m-2"></i><strong>Gestion de mangas</strong> <i class="fa-solid fa-caret-left m-2"></i></a></li>
                                <li><a class="dropdown-item" href="./Gestion de suscripciones.php"><i class="fa-solid fa-book m-2"></i>Gestion de suscripciones</a></li>                                <hr class="dropdown-divider">
                                <li><a class="dropdown-item" href="./Gestion de etiquetas.php"><i class="fa-solid fa-book m-2"></i>Gestion de etiquetas</a></li>
                                <li><a class="dropdown-item" href="./Gestion de capitulos.php"><i class="fa-solid fa-book m-2"></i>Gestion de capitulos</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="./Gestion de usuarios.php"><i class="fa-solid fa-user m-2"></i>Usuarios</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-regular fa-file m-2"></i>Reportes</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="./Reportes financieros.php"><i class="fa-regular fa-file m-2"></i>Financiero</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="./Gestion de planes.php"><i class="fa-solid fa-gem m-2"></i>Planes</a>
                        </li>
                    </ul>
                    <form class="d-flex mt-3">
                        <a class=" btn btn-outline-danger" href="?cerrar_sesion">Cerrar Sesión</a>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Formulario para agregar mangas -->


    <form class="row needs-validation p-5 h-100 m-5 text-white bg-dark border rounded-3" method="POST">
        <input type="hidden" name="idUsuario" value="">

        <div class="row justify-content-center">
            <div class="row align-items-md-stretch text-center">
                <div class="col-md-12">
                    <div class="h-100 p-5 text-white bg-dark border rounded-3">
                        <h2>Añadir nuevos usuarios</h2>
                        <hr>

                       
                    </div>
                </div>

            </div>

        </div>

        <div class="row justify-content-center">
            <div class="col-md-7 mb-3">
                <label for="validationCustom01" class="form-label">
                    <h5>Nombre</h5>
                </label>
                <input type="text" class="form-control" id="txtnombre" name="txtnombre" value="" required placeholder="Ingresar nombre(s)">
                <div class="valid-feedback">
                    Bien!
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-7 mb-3">
                <label for="validationCustom02" class="form-label">
                    <h5>Apellido</h5>
                </label>
                <input type="text" class="form-control" id="txtapellido" name="txtapellido" value="" required placeholder="Ingresar apellido(s)">

            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-7 mb-3">
                <label for="validationCustom02" class="form-label">
                    <h5>Correo</h5>
                </label>
                <input type="mail" class="form-control" id="txtcorreo" name="txtcorreo" value="" required placeholder="Ingresar correo (ej.): example@example.com">

            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-7 mb-3">
                <label for="validationCustom02" class="form-label">
                    <h5>Contraseña</h5>
                </label>
                <input type="password" class="form-control" id="txtcontraseña" name="txtcontraseña" value="" required placeholder="Ingresar contraseña:">

            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-3 mb-3">
                <label for="validationCustom02" class="form-label">
                    <h5>Rol</h5>
                </label>
                <select class="form-select" id="exampleSelect1" required name="selectrol">
                    <option selected disabled value="">Seleccionar Rol...</option>
                    <?php foreach ($Roles as $Rol) { ?>
                        <option value="<?php echo $Rol['IdRol']; ?>"><?php echo $Rol['NombreRol']; ?></option>
                    <?php } ?>

                </select>
            </div>


            <div class="col-md-3 mb-3">
                <label for="validationCustom02" class="form-label">
                    <h5>Plan</h5>
                </label>
                <select class="form-select" id="exampleSelect1" required name="selectplan">
                    <option selected disabled value="">Seleccionar Plan...</option>
                    <?php foreach ($Planes as $Plan) { ?>
                        <option value="<?php echo $Plan['IdPlan']; ?>"><?php echo $Plan['TituloPlan']; ?></option>
                    <?php } ?>

                </select>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-2 mt-5">
                <button class="btn btn-primary" type="submit">Agregar nuevo usuario</button>
            </div>
        </div>
    </form>



    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://kit.fontawesome.com/9319846bc5.js" crossorigin="anonymous"></script>

    <script src="../Scrips/Animaciones-Administrador/Administrador.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="../Scrips/Gestion.js"></script>

</body>

</html>