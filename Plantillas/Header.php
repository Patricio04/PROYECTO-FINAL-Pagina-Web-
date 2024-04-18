<?php ob_start();
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tatsu</title>

    <link rel="Stylesheet" href="Styles/bootstrap.min.css" />
    <link rel="Stylesheet" href="Styles/normalize.css" />
    <link rel="Stylesheet" href="Styles/index.css" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Honk&family=Rubik+Glitch+Pop&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Rubik+Glitch+Pop&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Silkscreen:wght@400;700&display=swap" rel="stylesheet">

</head>



<body>
    <?php $url="http://".$_SERVER['HTTP_HOST']."/PROYECTO-FINAL-Pagina-Web-"?>  <!-- Esto sirve para redireccionar a la carpeta principal del proyecto (por el momento se llama "PROYECTO-FINAL-Pagina-Web-"), ['HTTP_HOST'] sirve para colocar al principio el nombre del host actual (por el momento el host es "localhost"), esto para que si lo llegamos a subir y le cambiamos el nombre al host por algo como "Tatsu.com" ahora este sea el nombre del HOST y no haya inconvenientes con páginas que no se ven porque el direccionamiento está incorrecto-->

    <header class="header-est">
        <!-- Encabezado de la página -->
        <nav class="navbar navbar-expand-lg navbar-light  header estetic">
            <div class="container-fluid">
                <a class="navbar-brand  link-light" href="<?php echo $url;?>"> <!-- Al dar clic a Tatsu se redirecciona a la página principal del proyecto que vendría siendo la siguiente POR EL MOMENTO: "http://localhost/PROYECTO-FINAL-Pagina-Web-" -->
                    <img src="./Img/noto-v1_tornado.png" alt="Tatsu logo">Tatsu
                    <img class="container--img-anime" width="64" height="64"
                        src="https://img.icons8.com/nolan/64/kuromi.png" alt="kuromi" />
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ul-center">
                        <img class="container-ul-img-sb" src="./Img/sombra.png" alt="">
                        <li class="nav-item">
                            <a class="nav-link link-light" href="#">Directorio de Mangas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link link-margin link-light" href="#">Premium
                                <img class="img-premium nav-link" src="./Img/Diamante.png" alt="LogoPremium">
                            </a>
                        </li>
                        <li class="nav-item tm">
                            <a class="nav-link link-red link-light  " href="#">Favoritos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link link-light " href="Usuario/Mi cuenta.php">Usuario</a>
                        </li>

                        <li class="nav-item dropdown ">
                            <a class="nav-link dropdown-toggle link-light " href="#" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Categorias
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </li>

                    </ul>
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-light" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>
    </header>

    

