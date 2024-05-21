<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador - Agregar Contenido de Capítulo</title>
    <link rel="stylesheet" href="../Styles/AdministradorCSS/Administrador.css">
    <link rel="stylesheet" href="../Styles/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<?php
require '../Assets/Bases de datos/db.php';

// Obtener los capítulos
$sql = "SELECT IdCapitulo, NombreCapitulo FROM Capitulo";
$resultado = $conn->query($sql);

$Capitulos = array();
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $Capitulos[] = array(
            "IdCapitulo" => $fila["IdCapitulo"],
            "NombreCapitulo" => $fila["NombreCapitulo"]
        );
    }
} else {
    echo "No se encontraron capítulos.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idCapitulo = intval($_POST['idCapitulo']);
    $descripcionContenido = $_POST['descripcionContenido'];
    $urlImagen = $_POST['urlImagen'];

    $sql = "INSERT INTO ContenidoCapitulo (IdCapitulo, ImagenContenido, Orden) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isi", $idCapitulo, $urlImagen, $descripcionContenido);

    if ($stmt->execute()) {
        echo "<div class='alert alert-dismissible alert-info' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 1000;'>
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
        <strong>El contenido se agregó correctamente</strong></div>";
    } else {
        echo "Error al agregar el contenido: " . $stmt->error;
    }
}

?>

<body>
<nav class="navbar bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand  link-light" href="./Gestion-de-mangas.php">
                <img src="../Img/noto-v1_tornado.png" alt="Tatsu logo">Tatsu
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
                                <li><a class="dropdown-item" href="./Gestion-de-mangas.php"><i class="fa-solid fa-book m-2"></i>Gestión de mangas</a></li>
                                <li><a class="dropdown-item" href="./Gestion de suscripciones.php"><i class="fa-solid fa-book m-2"></i>Gestión de suscripciones</a></li>
                                <hr class="dropdown-divider">
                                <li><a class="dropdown-item" href="./Gestion de etiquetas.php"><i class="fa-solid fa-book m-2"></i>Gestión de etiquetas</a></li>
                                <li><a class="dropdown-item" href="./Gestion de capitulos.php"><i class="fa-solid fa-book m-2"></i>Gestión de capítulos </a></li>
                                <li><a class="dropdown-item" href="./Gestion de contenidocapitulos.php"><i class="fa-solid fa-book m-2"></i>Gestión de contenidos<i class="fa-solid fa-caret-left m-2"></i></a></li>

                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="./Gestion de usuarios.php"><i class="fa-solid fa-user m-2"></i>Usuarios</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-regular fa-file m-2"></i>Reportes
                            </a>
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

    <!-- Formulario para agregar contenidos de capítulos -->
    <form class="row needs-validation p-5 h-100 m-5 text-white bg-dark border rounded-3" method="POST">
        <div class="row justify-content-center">
            <div class="row align-items-md-stretch text-center">
                <div class="col-md-12">
                    <div class="h-100 p-5 text-white bg-dark border rounded-3">
                        <h2>Agregar Contenido de Capítulo</h2>
                        <hr>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-7 mb-3">
                <label for="selectCapitulo" class="form-label">
                    <h5>Capítulo</h5>
                </label>
                <select class="form-select" id="selectCapitulo" required name="idCapitulo">
                    <option selected disabled value="">Seleccionar Capítulo...</option>
                    <?php foreach ($Capitulos as $Capitulo) { ?>
                        <option value="<?php echo $Capitulo['IdCapitulo']; ?>"><?php echo $Capitulo['NombreCapitulo']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-7 mb-3">
                <label for="descripcionContenido" class="form-label">
                    <h5>Orden de contenido</h5>
                </label>
                <input type="number" class="form-control" id="descripcionContenido" name="descripcionContenido" required placeholder="Ingresar descripción del contenido">
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-7 mb-3">
                <label for="urlImagen" class="form-label">
                    <h5>URL de la Imagen</h5>
                </label>
                <input type="text" class="form-control" id="urlImagen" name="urlImagen" required placeholder="Ingresar URL de la imagen">
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-2 mt-5">
                <button class="btn btn-primary" type="submit">Agregar Contenido</button>
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
