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

// Consulta SQL para obtener los datos de la tabla "mangas"
$sql = "SELECT * FROM `mangas`;";

// Ejecutar la consulta
$resultado = $conn->query($sql);

// Verificar si hay resultados
if ($resultado->num_rows > 0) {
    // Crear un array para almacenar los datos de los mangas
    $mangas = array();

    // Recorrer los resultados y guardarlos en el array
    while ($fila = $resultado->fetch_assoc()) {
        $mangas[] = $fila;
    }
} else {
    // Si no hay resultados, mostrar un mensaje
    echo "<p>No se encontraron mangas.</p>";
}

// Cerrar la conexión
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
    <!-- Contenedor de la tabla -->
    <div class="container mt-5">

        <div class="row justify-content-center">

            <div class="col-md-10">

                <table class="table table-hover table-striped">
                    <thead>
                        <caption>
                            
                        </caption>
                        <tr>
                            <th scope="col " class="align-middle text-center">ID_Manga</th>
                            <th scope="col " class="align-middle text-center">Titulo</th>
                            <th scope="col " class="align-middle text-center">Descripcion</th>
                            <th scope="col " class="align-middle text-center">Portada</th>
                            <th scope="col " class="align-middle text-center">Registro</th>
                        </tr>
                    </thead>
                    <?php foreach ($mangas as $manga) { ?><!-- Iteramos con un foreach para generar rows de la tabla cada que haya un manga dentro de la base de datos-->
                        <tr id="manga-<?php echo $manga['id_manga']; ?>" class="table-primary">
                            <th scope="row" class="align-middle text-center"><?php echo $manga['id_manga']; ?></th>
                            <td class="align-middle text-center"><?php echo $manga['titulo']; ?></td>
                            <td class="align-middle text-center"><?php echo $manga['descripcion']; ?></td>
                            <td class="align-middle text-center"><img src="<?php echo $manga['portada']; ?>" alt="Portada del manga" class="portada-imagen"></td>
                            <td class="align-middle text-center">
                                <a href="" class="text-white">
                                    <i class="fa-solid fa-pen-to-square fa-xl m-3" ></i>
                                </a>
                                <a href="" class="text-white ancoreborrar" data-id="<?php echo $manga['id_manga']; ?>">
                                    <i class="fa-solid fa-trash fa-lg m-3"></i>
                                </a>
                            </td>
                        </tr>

                    <?php } ?>
                </table>
            </div>

        </div>





    </div>




    <?php include '../Plantillas/Footer.php' ?>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../Scrips/Animaciones-Administrador/Administrador.js"></script>
</body>

</html>

