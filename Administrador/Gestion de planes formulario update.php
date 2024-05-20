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


// Verificar si hay un ID de etiqueta en la URL
$idPlan = isset($_GET['id']) ? intval($_GET['id']) : 0;
$planes = null;

// Si hay un ID de etiqueta, cargar los datos de la etiqueta
if ($idPlan > 0) {
    $sql = "SELECT * FROM Planes WHERE IdPlan = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idPlan);
    $stmt->execute();
    $result = $stmt->get_result();
    $planes = $result->fetch_assoc();
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Datos del formulario
    $idPlan = intval($_POST['idPlan']);
    $nombrePlan = $_POST['txtnombre'];
    $descripcion = $_POST['txtareadescripcion'];
    $precio = floatval($_POST['txtprecio']);
    $activo = $_POST['txtactivo'];

    $sql = "UPDATE Planes SET TituloPlan = ?, DescripcionPlan = ?, PrecioPlan = ? , Activo = ? WHERE IdPlan = ?";
    $stmt = $conn->prepare($sql);

    // Vincular parámetros y ejecutar la consulta
    $stmt->bind_param("ssdsi", $nombrePlan, $descripcion, $precio, $activo , $idPlan);

    if ($stmt->execute()) {
        // Redirigir después de la actualización
        header("Location: Gestion de planes.php");
        exit();
    } else {
        echo "Error al actualizar el plan: " . $stmt->error;
    }

    $stmt->close();
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
                            <ul class="dropdown-menu hidden">
                                <li><a class="dropdown-item" href="./Gestion-de-mangas.php"><i class="fa-solid fa-book m-2"></i>Gestion de mangas</a></li>
                                <li><a class="dropdown-item" href="./Gestion de carrsuel.php"><i class="fa-solid fa-book m-2"></i>Gestion de carrusel</a></li>
                                <hr class="dropdown-divider">
                                <li><a class="dropdown-item" href="./Gestion de etiquetas.php"><i class="fa-solid fa-book m-2"></i>Gestion de etiquetas</a></li>
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
                            <a class="nav-item text-decoration-none" href="./Gestion de planes.php"><i class="fa-solid fa-gem m-2"></i><strong>Planes</strong><i class="fa-solid fa-caret-left m-2"></i></a>
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
        <input type="hidden" name="idPlan" value="<?php echo $planes ? htmlspecialchars($planes['IdPlan']) : ''; ?>">

        <div class="row justify-content-center">
            <div class="row align-items-md-stretch text-center">
                <div class="col-md-12">
                    <div class="h-100 p-5 text-white bg-dark border rounded-3">
                        <h2>Añadir nuevos planes</h2>
                        <hr>


                    </div>
                </div>

            </div>

        </div>

        <div class="row justify-content-center">
            <div class="col-md-7 mb-3">
                <label for="validationCustom01" class="form-label">
                    <h5>Nombre del plan</h5>
                </label>
                <input type="text" class="form-control" id="txtnombre" name="txtnombre" value="<?php echo $planes ? htmlspecialchars($planes['TituloPlan']) : ''; ?>" required placeholder="Ingresar nombre del plan">
                <div class="valid-feedback">
                    Bien!
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-7 mb-3">
                <label for="exampleTextarea" class="form-label ">
                    <h5>Descripción</h5>
                </label>
                <textarea class="form-control" id="txtareadescripcion" name="txtareadescripcion" rows="3" placeholder="Ingrese una descripcion sobre las caracteristicas del nuevo plan"><?php echo $planes ? htmlspecialchars($planes['DescripcionPlan']) : ''; ?></textarea>
                <div class="invalid-feedback">
                    Por favor coloque una descripción
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-7 mb-3">
                <label for="validationCustom02" class="form-label">
                    <h5>Precio del nuevo plan</h5>
                </label>
                <input type="text" class="form-control" id="txtprecio" name="txtprecio" value="<?php echo $planes ? htmlspecialchars($planes['PrecioPlan']) : ''; ?>" required placeholder="Ingresar descripcion">

            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-7 mb-3">
                <label for="validationCustom02" class="form-label">
                    <h5>Activo / Descontinuado (1 | 0)</h5>
                </label>
                <input type="text" class="form-control" id="txtprecio" name="txtactivo" value="<?php echo $planes ? htmlspecialchars($planes['Activo']) : ''; ?>" required placeholder="Ingresar descripcion">

            </div>
        </div>


        <div class="row justify-content-center">
            <div class="col-md-2 mt-5">
                <button class="btn btn-primary" type="submit">Guardar cambios</button>
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