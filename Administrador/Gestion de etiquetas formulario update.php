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
// archivo de conexion a la BD
require '../Assets/Bases de datos/db.php';




if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Datos del formulario
    $idEtiqueta = intval($_POST['idEtiqueta']);
    $nombreEtiqueta = $_POST['txtetiqueta'];

    // Actualiza la etiqueta
    $sql = "UPDATE Etiqueta SET NombreEtiqueta = ? WHERE IdEtiqueta = ?";
    $stmt = $conn->prepare($sql);

    // Vincular parámetros y ejecutar la consulta
    $stmt->bind_param("si", $nombreEtiqueta, $idEtiqueta);
    $stmt->execute();

    // Redirigir después de la actualización
    header("Location: Gestion de etiquetas.php");
    exit();
}



// Verificar si hay un ID de etiqueta en la URL
$idEtiqueta = isset($_GET['id']) ? intval($_GET['id']) : 0;
$etiqueta = null;

// Si hay un ID de etiqueta, cargar los datos de la etiqueta
if ($idEtiqueta > 0) {
    $sql = "SELECT * FROM Etiqueta WHERE IdEtiqueta = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idEtiqueta);
    $stmt->execute();
    $result = $stmt->get_result();
    $etiqueta = $result->fetch_assoc();
}

// Cerrar la conexión
$stmt->close();





?>



<body>
    <nav class="navbar bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand  link-light" href="#">
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
                                <li><a class="dropdown-item" href="./Gestion-de-mangas.php"><i class="fa-solid fa-book m-2"></i>Gestion de mangas</a></li>
                                <li><a class="dropdown-item" href="./Gestion de carrsuel.php"><i class="fa-solid fa-book m-2"></i>Gestion de carrusel</a></li>
                                <hr class="dropdown-divider">
                                <li><a class="dropdown-item" href="./Gestion de etiquetas.php"><i class="fa-solid fa-book m-2"></i><strong>Gestion de etiquetas</strong> <i class="fa-solid fa-caret-left m-2"></i></a></li>
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
                                <li><a class="dropdown-item" href="./Reportes de visualizacion.php"><i class="fa-regular fa-file m-2"></i>Datos de visualizacion</a></li>
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


    <form class="row needs-validation p-5 m-5 text-white bg-dark border rounded-3 justify-content-center" method="POST">
        <input type="hidden" name="idEtiqueta" value="<?php echo $etiqueta ? htmlspecialchars($etiqueta['IdEtiqueta']) : ''; ?>">

        <div class="col-md-4">
            <label for="txtetiqueta" class="form-label">
                <h5>Nombre de la etiqueta: </h5>
            </label>
            <input type="text" class="form-control" id="txtetiqueta" name="txtetiqueta" value="<?php echo $etiqueta ? htmlspecialchars($etiqueta['NombreEtiqueta']) : ''; ?>" required placeholder="Ingresar nombre de la etiqueta (Max. 255 caracteres)">
            <div class="valid-feedback">
                ¡Bien!
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-2 mt-5 ">
                <button class="btn btn-primary" type="submit">Actualizar etiqueta</button>
            </div>
        </div>
    </form>



    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://kit.fontawesome.com/9319846bc5.js" crossorigin="anonymous"></script>

    <script src="../Scrips/Animaciones-Administrador/Administrador.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="../Scrips/Gestion.js"></script>

</body>