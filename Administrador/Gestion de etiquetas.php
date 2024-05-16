<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
    <link rel="stylesheet" href="../Styles/AdministradorCSS/Administrador.css">
    <link rel="stylesheet" href="../Styles/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap5.css">

</head>

<?php

require '../Assets/Bases de datos/db.php';
include '../Plantillas/HeaderAdmin.php';

// Consulta SQL para obtener los datos de la tabla "etiquetas"
$sql = "SELECT * FROM Etiqueta;";

// Ejecutar la consulta
$resultado = $conn->query($sql);

// Verificar si hay resultados
if ($resultado->num_rows > 0) {
    // Crear un array para almacenar los datos de las etiquetas
    $etiquetas = array();

    // Recorrer los resultados y guardarlos en el array
    while ($fila = $resultado->fetch_assoc()) {
        $etiquetas[] = $fila;
    }
} else {
    // Si no hay resultados, mostrar un mensaje
    echo "<p>No se encontraron etiquetas.</p>";
}


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
                                <li><a class="dropdown-item" href="#"><i class="fa-solid fa-book m-2"></i><strong>Gestion de etiquetas</strong> <i class="fa-solid fa-caret-left m-2"></i></a></li>
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

    <!-- Contenedor de la tabla -->
    <div class="container mt-5">

        <div class="row justify-content-center">
            <div class="row align-items-md-stretch text-center">
                <div class="col-md-12">
                    <div class="h-100 p-5 text-white bg-dark border rounded-3">
                        <h2>Gestion de Etiquetas</h2>
                        <hr>
                        <p>

                        </p>

                        <a class="btn btn-outline-primary " type="button" href="../Administrador/Gestion de etiquetas formulario.php"> <i class="fa-solid fa-square-plus fa-xl m-2"></i>Agregar nueva etiqueta</a>
                    </div>
                </div>

            </div>

        </div>

        <div class="row justify-content-center mt-5 mb-5 ">

            <div class="col-md-12 ">
                <div class="table-responsive h-100 p-5 text-white bg-dark border rounded-3 overflow-auto">

                    <table class="table table-hover table-striped" id="tablaEtiquetas">
                        <thead>
                            <tr>
                                <th scope="col" class="align-middle text-center">EtiquetaID</th>
                                <th scope="col" class="align-middle text-center">Nombre de la etiqueta</th>
                                <th scope="col" class="align-middle text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="etiquetaTableBody">
                            <?php foreach ($etiquetas as $etiqueta) { ?>
                                <tr id="etiqueta-<?php echo $etiqueta['IdEtiqueta']; ?>" class="table-primary">
                                    <td scope="row" class="align-middle text-center"><?php echo $etiqueta['IdEtiqueta']; ?></td>
                                    <td class="align-middle text-center"><?php echo $etiqueta['NombreEtiqueta']; ?></td>
                                    <td class="align-middle text-center">
                                        <a href="./Gestion de etiquetas formulario update.php?id=<?php echo $etiqueta['IdEtiqueta']; ?>" class="text-white">
                                            <i class="fa-solid fa-pen-to-square fa-xl m-3"></i>
                                        </a>
                                        <a href="" class="text-white ancoreborrar" data-id="<?php echo $etiqueta['IdEtiqueta']; ?>">
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

    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const table = new DataTable('#tablaEtiquetas', {
                pageLength: 3,
                language: {
                    lengthMenu: "Mostrar _MENU_ registros por página",
                    zeroRecords: "Ninguna etiqueta encontrada",
                    info: "Mostrando de _START_ a _END_ de un total de _TOTAL_ registros",
                    infoEmpty: "Ninguna etiqueta encontrada",
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

            function attachDeleteEvent() {
                const deleteLinks = document.querySelectorAll('.ancoreborrar');

                deleteLinks.forEach(function(link) {
                    link.addEventListener('click', function(event) {
                        event.preventDefault();

                        const etiquetaId = this.getAttribute('data-id');
                        const confirmed = confirm('¿Estás seguro de que deseas eliminar esta etiqueta?');

                        if (confirmed) {
                            fetch('../Plantillas/eliminar_etiqueta.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        id: etiquetaId
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        const row = document.getElementById('etiqueta-' + etiquetaId);
                                        row.parentNode.removeChild(row);
                                    } else {
                                        alert('Error al eliminar la etiqueta: ' + data.message);
                                    }
                                })
                                .catch(error => console.error('Error:', error));
                        } else {
                            console.log('Eliminación de la etiqueta cancelada.');
                        }
                    });
                });
            }

            // Attach event listeners on initial load
            attachDeleteEvent();

            // Attach event listeners on every draw event
            table.on('draw', function() {
                attachDeleteEvent();
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteLinks = document.querySelectorAll('.ancoreborrar');

            deleteLinks.forEach(function(link) {
                link.addEventListener('click', function(event) {
                    event.preventDefault();

                    const etiquetaId = this.getAttribute('data-id');
                    const confirmed = confirm('¿Estás seguro de que deseas eliminar esta etiqueta?');

                    if (confirmed) {
                        fetch('../Plantillas/eliminar_etiqueta.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    id: etiquetaId
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    const row = document.getElementById('etiqueta-' + etiquetaId);
                                    row.parentNode.removeChild(row);
                                } else {
                                    alert('Error al eliminar la etiqueta: ' + data.message);
                                }
                            })
                            .catch(error => console.error('Error:', error));
                    } else {
                        console.log('Eliminación de la etiqueta cancelada.');
                    }
                });
            });
        });
    </script>



</body>