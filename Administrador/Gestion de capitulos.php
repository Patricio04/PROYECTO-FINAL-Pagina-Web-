<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Capítulos</title>
    <link rel="stylesheet" href="../Styles/AdministradorCSS/Administrador.css">
    <link rel="stylesheet" href="../Styles/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap5.css">
</head>

<?php
// archivo de conexion a la BD
require '../Assets/Bases de datos/db.php';
include '../Plantillas/HeaderAdmin.php';

// Consulta SQL para obtener los datos de la tabla "capitulo"
$sql = "SELECT * FROM Capitulo;";

// Ejecutar la consulta
$resultado = $conn->query($sql);

// Verificar si hay resultados
if ($resultado->num_rows > 0) {
    // Crear un array para almacenar los datos de los capítulos
    $capitulos = array();

    // Recorrer los resultados y guardarlos en el array
    while ($fila = $resultado->fetch_assoc()) {
        $capitulos[] = $fila;
    }
} else {
    // Si no hay resultados, mostrar un mensaje
    echo "<p>No se encontraron capítulos.</p>";
}

// Cerrar la conexión
$conn->close();
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
                                <li><a class="dropdown-item" href="./Gestion de mangas.php"><i class="fa-solid fa-book m-2"></i>Gestión de mangas</a></li>
                                <li><a class="dropdown-item" href="./Gestion de suscripciones.php"><i class="fa-solid fa-book m-2"></i>Gestión de suscripciones</a></li>
                                <hr class="dropdown-divider">
                                <li><a class="dropdown-item" href="./Gestion de etiquetas.php"><i class="fa-solid fa-book m-2"></i>Gestión de etiquetas</a></li>
                                <li><a class="dropdown-item" href="./Gestion de capitulos.php"><i class="fa-solid fa-book m-2"></i><strong>Gestión de capítulos</strong> <i class="fa-solid fa-caret-left m-2"></i></a></li>
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
                        <a class="btn btn-outline-danger" href="?cerrar_sesion">Cerrar Sesión</a>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenedor de la tabla -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="row align-items-md-stretch text-center">
                <div class="col-md-12">
                    <div class="h-100 p-5 text-white bg-dark border rounded-3">
                        <h2>Gestión de capítulos</h2>
                        <hr>
                        <p></p>
                        <a class="btn btn-outline-primary" type="button" href="./Gestion de capitulos formulario.php"><i class="fa-solid fa-square-plus fa-xl m-2"></i>Agregar nuevo capítulo</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-5 mb-5">
            <div class="col-md-12">
                <div class="table-responsive h-100 p-5 text-white bg-dark border rounded-3 overflow-auto">
                    <table class="table table-hover table-striped" id="myTable">
                        <thead>
                            <tr>
                                <th scope="col" class="align-middle text-center">ID_Capítulo</th>
                                <th scope="col" class="align-middle text-center">ID_Manga</th>
                                <th scope="col" class="align-middle text-center">Nombre del Capítulo</th>
                                <th scope="col" class="align-middle text-center">Orden</th>
                                <th scope="col" class="align-middle text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($capitulos as $capitulo) { ?>
                                <tr id="capitulo-<?php echo $capitulo['IdCapitulo']; ?>" class="table-primary">
                                    <td scope="row" class="align-middle text-center"><?php echo $capitulo['IdCapitulo']; ?></td>
                                    <td class="align-middle text-center"><?php echo $capitulo['IdManga']; ?></td>
                                    <td class="align-middle text-center"><?php echo $capitulo['NombreCapitulo']; ?></td>
                                    <td class="align-middle text-center"><?php echo $capitulo['Orden']; ?></td>
                                    <td class="align-middle text-center">
                                        <a href="./Gestion de capitulos formulario update.php?id=<?php echo $capitulo['IdCapitulo']; ?>" class="text-white">
                                            <i class="fa-solid fa-pen-to-square fa-xl m-3"></i>
                                        </a>
                                        <a href="#" class="text-white ancoreborrar" data-id="<?php echo $capitulo['IdCapitulo']; ?>">
                                            <i class="fa-solid fa-trash fa-lg m-3"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://kit.fontawesome.com/9319846bc5.js" crossorigin="anonymous"></script>
    <script src="../Scrips/Animaciones-Administrador/Administrador.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar DataTable para la tabla de capítulos
            const table = new DataTable('#myTable', {
                pageLength: 3,
                language: {
                    lengthMenu: "Mostrar _MENU_ registros por página",
                    zeroRecords: "Ningún capítulo encontrado",
                    info: "Mostrando del _START_ al _END_ de un total de _TOTAL_ registros",
                    infoEmpty: "Ningún capítulo encontrado",
                    infoFiltered: "(filtrados desde _MAX_ registros totales)",
                    search: "Buscar: ",
                    loadingRecords: "Cargando...",
                    paginate: {
                        first: "Primero",
                        last: "Último",
                        next: "Siguiente",
                        previous: "Anterior"
                    }
                }
            });

            // Función para adjuntar eventos de eliminación
            function attachDeleteEvent() {
                const deleteLinks = document.querySelectorAll('.ancoreborrar');

                deleteLinks.forEach(function(link) {
                    link.addEventListener('click', function(event) {
                        event.preventDefault();

                        const capituloId = this.getAttribute('data-id');
                        const confirmed = confirm('¿Estás seguro de que deseas eliminar este capítulo?');

                        if (confirmed) {
                            fetch('../Plantillas/eliminar_capitulo.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        id: capituloId
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        const row = document.getElementById('capitulo-' + capituloId);
                                        row.parentNode.removeChild(row);
                                    } else {
                                        alert('Error al eliminar el capítulo: ' + data.message);
                                    }
                                })
                                .catch(error => console.error('Error:', error));
                        } else {
                            console.log('Eliminación del capítulo cancelada.');
                        }
                    });
                });
            }

            // Adjuntar eventos de eliminación al cargar la página
            attachDeleteEvent();

            // Adjuntar eventos de eliminación cada vez que se redibuje la tabla
            table.on('draw', function() {
                attachDeleteEvent();
            });
        });
    </script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.js"></script>
</body>

</html>