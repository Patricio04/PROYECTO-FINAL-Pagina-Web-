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
$sql = "SELECT IdEtiqueta, NombreEtiqueta FROM Etiqueta";
$resultado = $conn->query($sql);

// Comprueba si hay resultados y guarda los nombres y IDs de las etiquetas en un array asociativo
$etiquetas = array();
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $etiquetas[] = array(
            "id" => $fila["IdEtiqueta"],
            "nombre" => $fila["NombreEtiqueta"]
        );
    }
} else {
    echo "No se encontraron etiquetas.";
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idManga = intval($_POST['idManga']);
    $titulo = $_POST['txtitulo'];
    $portada = $_POST['txtportada'];
    $descripcion = $_POST['txtareadescripcion'];
    $etiquetas = $_POST['etiquetas'];

    // Inicia la transacción
    $conn->begin_transaction();

    try {
        // Actualiza el manga
        $sql = "UPDATE Manga SET Titulo = ?, Portada = ?, Descripcion = ? WHERE IdManga = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $titulo, $portada, $descripcion, $idManga);
        $stmt->execute();

        // Elimina las etiquetas asociadas al manga
        $sql = "DELETE FROM EtiquetaManga WHERE IdManga = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idManga);
        $stmt->execute();

        // Inserta las etiquetas del manga
        $sql = "INSERT INTO EtiquetaManga (IdManga, IdEtiqueta) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        foreach ($etiquetas as $idEtiqueta) {
            $stmt->bind_param("ii", $idManga, $idEtiqueta);
            $stmt->execute();
        }

        // Confirma la transacción
        $conn->commit();

        header("Location: Gestion-de-mangas.php"); // Redirige de vuelta a la gestión de mangas
        exit();
    } catch (Exception $e) {
        // Si ocurre un error, deshace la transacción
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    } finally {
        $stmt->close();
        $conn->close();
    }
}

  
   




// Verificar si hay un ID de manga en la URL
$idManga = isset($_GET['id']) ? intval($_GET['id']) : 0;
//echo "$idManga";
$manga = null;
$etiquetasSeleccionadas = [];

// Si hay un ID de manga, cargar los datos del manga
if ($idManga > 0) {
    $sql = "SELECT * FROM Manga WHERE IdManga = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idManga);
    $stmt->execute();
    $result = $stmt->get_result();
    $manga = $result->fetch_assoc();
    
    // Cargar las etiquetas asociadas al manga
    $sql = "SELECT IdEtiqueta FROM EtiquetaManga WHERE IdManga = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idManga);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $etiquetasSeleccionadas[] = $row['IdEtiqueta'];
    }
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
                                <li><a class="dropdown-item" href="./Gestion de contenidocapitulos.php"><i class="fa-solid fa-book m-2"></i>Gestión de contenidos</a></li>
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
    <input type="hidden" name="idManga" value="<?php echo $manga ? $manga['IdManga'] : ''; ?>">

        <div class="col-md-4">
            <label for="validationCustom01" class="form-label">
                <h5>Titulo</h5>
            </label>
            <input type="text" class="form-control" id="txtitulo" name="txtitulo" value="<?php echo $manga ? htmlspecialchars($manga['Titulo']) : ''; ?>" required placeholder="Ingresar titulo del manga (Max. 255 caracteres)">
            <div class="valid-feedback">
                Bien!
            </div>
        </div>
        <div class="col-md-4">
            <label for="validationCustom02" class="form-label">
                <h5>Portada</h5>
            </label>
            <input type="text" class="form-control" id="txtportada" name="txtportada" value="<?php echo $manga ? htmlspecialchars($manga['Portada']) : ''; ?>" required placeholder="Ingresar enlace de la portada">
            <small class="form-text text-muted">Por favor revisar la nube -> <a href="https://www.dropbox.com/home/Tatsu"><i class="fa-solid fa-cloud-arrow-up"></i></a></small>
        </div>
        <div class="col-md-4">
            <label for="validationCustom04" class="form-label">
                <h5>Etiquetas</h5>
            </label>
            <?php foreach ($etiquetas as $etiqueta) { ?>
                <div class="form-check">
                    <!-- Utilizamos el ID de la etiqueta como valor del checkbox -->
                    <input class="form-check-input" type="checkbox" value="<?php echo $etiqueta['id']; ?>" id="etiqueta_<?php echo $etiqueta['id']; ?>" name="etiquetas[]" <?php echo in_array($etiqueta['id'], $etiquetasSeleccionadas) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="etiqueta_<?php echo $etiqueta['id']; ?>">
                        <?php echo $etiqueta['nombre']; ?>
                    </label>
                </div>
            <?php } ?>
            <div class="invalid-feedback">
                Please select a valid state.
            </div>
        </div>
        <div class="col-md-6">
            <label for="exampleTextarea" class="form-label mt-4">
                <h5>Descripción</h5>
            </label>
            <textarea class="form-control" id="txtareadescripcion" name="txtareadescripcion" rows="3" placeholder="Indique la trama del manga (max. 1000 caracteres)"><?php echo $manga ? htmlspecialchars($manga['Descripcion']) : ''; ?></textarea>
            <div class="invalid-feedback">
                Por favor coloque una descripción
            </div>
        </div>


        
        <div class="col-12 mt-5">
            <button class="btn btn-primary" type="submit">Actualizar manga</button>
        </div>
    </form>



    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://kit.fontawesome.com/9319846bc5.js" crossorigin="anonymous"></script>

    <script src="../Scrips/Animaciones-Administrador/Administrador.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="../Scrips/Gestion.js"></script>

</body>

</html>