<!--Para acceder a este apartado el usuario que inicie sesion tiene que tener un ID_rol = 3 que es el indicado para administradores-->


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

// Consulta SQL para seleccionar todas las etiquetas
$sql = "SELECT nombre_etiqueta FROM etiquetas";
$resultado = $conn->query($sql);

// Comprueba si hay resultados y guarda los nombres de las etiquetas en un array
$etiquetas = array();
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $etiquetas[] = $fila["nombre_etiqueta"];
    }
} else {
    echo "No se encontraron etiquetas.";
}
$conn->close();
?>



<body>
    <?php $url = "http://" . $_SERVER['HTTP_HOST'] . "/PROYECTO-FINAL-Pagina-Web-" ?> <!-- Esto sirve para redireccionar a la carpeta principal del proyecto (por el momento se llama "PROYECTO-FINAL-Pagina-Web-"), ['HTTP_HOST'] sirve para colocar al principio el nombre del host actual (por el momento el host es "localhost"), esto para que si lo llegamos a subir y le cambiamos el nombre al host por algo como "Tatsu.com" ahora este sea el nombre del HOST y no haya inconvenientes con páginas que no se ven porque el direccionamiento está incorrecto-->

    <nav class="navbar bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand  link-light" href="<?php echo $url; ?>">
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
                                <li><a class="dropdown-item" href="#"><i class="fa-solid fa-book m-2"></i><strong>Gestion de mangas</strong> <i class="fa-solid fa-caret-left m-2"></i></a></li>
                                <li><a class="dropdown-item" href="#"><i class="fa-solid fa-book m-2"></i>Gestion de carrusel</a></li>
                                <hr class="dropdown-divider">
                                <li><a class="dropdown-item" href="#"><i class="fa-solid fa-book m-2"></i>Gestion de etiquetas</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#"><i class="fa-solid fa-user m-2"></i>Usuarios</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-regular fa-file m-2"></i>Reportes</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#"><i class="fa-regular fa-file m-2"></i>Financiero</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fa-regular fa-file m-2"></i>Datos de visualizacion</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#"><i class="fa-solid fa-gem m-2"></i>Planes</a>
                        </li>
                    </ul>
                    <form class="d-flex mt-3" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Formulario para agregar mangas -->
    <form class="row needs-validation p-5 h-100 m-5 text-white bg-dark border rounded-3" novalidate>
        <div class="col-md-4">
            <label for="validationCustom01" class="form-label">
                <h5>Titulo</h5>
            </label>
            <input type="text" class="form-control" id="txttitulo" value="" required placeholder="Ingresar titulo del manga (Max. 255 caracteres)">
            <div class="valid-feedback">
                Bien!
            </div>
        </div>
        <div class="col-md-4">
            <label for="validationCustom02" class="form-label">
                <h5>Portada</h5>
            </label>
            <input type="text" class="form-control" id="txtportada" value="" required placeholder="Ingresar enlace de la portada">
            <small class="form-text text-muted">Por favor revisar la nube -> <a href=""><i class="fa-solid fa-cloud-arrow-up"></i></a></small>
        </div>
        <div class="col-md-4">
            <label for="validationCustom04" class="form-label">
                <h5>Etiquetas</h5>
            </label>
            <select class="form-select" required id="etiquetasopciones">
                <option selected disabled value="">Opciones...</option>
                <?php // itera sobre el array etiquetas y genera una option por cada etiqueta existente
                foreach ($etiquetas as $etiqueta) {
                    echo '<option value="' . $etiqueta . '">' . $etiqueta . '</option>';
                }
                ?>
                
            </select>
            <div class="invalid-feedback">
                Please select a valid state.
            </div>
        </div>
        <div class="col-md-6">
            <label for="exampleTextarea" class="form-label mt-4">
                <h5>Descripción</h5>
            </label>
            <textarea class="form-control" id="txtareadescripcion" rows="3" placeholder="Indique la trama del manga (max. 1000 caracteres)"></textarea>
            <div class="invalid-feedback">
                Por favor coloque una descripción
            </div>
        </div>


        <div class="col-12">
            falta decidir si colocar aqui el formulario de los capitulos y el contenido_capitulos o separarlos (ya que si no hay un manga creado antes no pueden existir capitulos, y sin capitulos no pueden existir contenido de capitulos)
        </div>
        <div class="col-12 mt-5">
            <button class="btn btn-primary" type="submit">Submit form</button>
        </div>
    </form>



    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://kit.fontawesome.com/9319846bc5.js" crossorigin="anonymous"></script>

    <script src="../Scrips/Animaciones-Administrador/Administrador.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


</body>

</html>