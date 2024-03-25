<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tatsu</title>

    <link rel="Stylesheet" href="./Styles/bootstrap.min.css" />
    <link rel="Stylesheet" href="./Styles/normalize.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Silkscreen:wght@400;700&display=swap" rel="stylesheet">
    <link rel="Stylesheet" href="./Styles/index.css" />

</head>

<body>

    <header>
        <!-- Encabezado de la página -->
        <nav class="navbar navbar-expand-lg navbar-light  header">
            <div class="container-fluid">
                <a class="navbar-brand  link-light" href="#">
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
                            <a class="nav-link link-light " href="#">Usuario</a>
                        </li>

                        <li class="nav-item dropdown ">
                            <a class="nav-link dropdown-toggle link-light " href="#" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Generos
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
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>
    </header>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

</body>

</html>