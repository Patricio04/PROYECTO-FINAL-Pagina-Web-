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

$sql = "SELECT * FROM Planes";

$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {
    $planes = array();

    while ($fila = $resultado->fetch_assoc()) {
        $planes[] = $fila;
    }
} else {
    echo "<p>No se encontraron usuarios.</p>";
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
                                <li><a class="dropdown-item" href="./Gestion de suscripciones.php"><i class="fa-solid fa-book m-2"></i>Gestion de suscripciones</a></li>                                <hr class="dropdown-divider">
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
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-item text-decoration-none" href="#"><i class="fa-solid fa-gem m-2"></i><strong>Planes</strong><i class="fa-solid fa-caret-left m-2"></i></a>
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
                        <h2>Gestion de Planes</h2>
                        <hr>
                        <p>

                        </p>

                        <a class="btn btn-outline-primary " type="button" href="../Administrador/Gestion de planes formulario.php"> <i class="fa-solid fa-square-plus fa-xl m-2"></i>Agregar nuevo plan</a>

                    </div>
                </div>

            </div>

        </div>

        <div class="row justify-content-center mt-5 mb-5 ">

            <div class="col-md-12 ">
                <div class="table-responsive h-100 p-5 text-white bg-dark border rounded-3 overflow-auto">

                    <table class="table table-hover table-striped" id="tablaPlanes">
                        <thead>
                            <tr>
                                <th scope="col" class="align-middle text-center">ID</th>
                                <th scope="col" class="align-middle text-center">Tipo</th>
                                <th scope="col" class="align-middle text-center">Descripcion</th>
                                <th scope="col" class="align-middle text-center">Precio</th>
                                <th scope="col" class="align-middle text-center">Activo</th>
                                <th scope="col" class="align-middle text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="planTableBody">
                            <?php foreach ($planes as $plan) { ?>
                                <tr id="plan-<?php echo $plan['IdPlan']; ?>" class="table-primary">
                                    <td scope="row" class="align-middle text-center"><?php echo $plan['IdPlan']; ?></td>
                                    <td class="align-middle text-center"><?php echo $plan['TituloPlan']; ?></td>
                                    <td class="align-middle text-center"><?php echo $plan['DescripcionPlan']; ?></td>
                                    <td class="align-middle text-center"><?php echo $plan['PrecioPlan']; ?></td>
                                    <td class="align-middle text-center"><?php echo $plan['Activo']; ?></td>
                                    <td class="align-middle text-center">
                                        <a href="./Gestion de planes formulario update.php?id=<?php echo $plan['IdPlan']; ?>" class="text-white">
                                            <i class="fa-solid fa-pen-to-square fa-xl m-3"></i>
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
            const table = new DataTable('#tablaPlanes', {
                pageLength: 3,
                language: {
                    lengthMenu: "Mostrar _MENU_ registros por página",
                    zeroRecords: "Ningún plan encontrado",
                    info: "Mostrando del _START_ al _END_ de un total de _TOTAL_ registros",
                    infoEmpty: "Ningún plan encontrado",
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

                        const planId = this.getAttribute('data-id');
                        const confirmed = confirm('¿Estás seguro de que deseas descontinuar este plan?');

                        if (confirmed) {
                            fetch('../Plantillas/eliminar_planes.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        id: planId
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        alert('Plan eliminado correctamente.');
                                    } else {
                                        alert('Error al eliminar el plan: ' + data.message);
                                    }
                                })
                                .catch(error => console.error('Error:', error));
                        } else {
                            console.log('Eliminación del plan cancelada.');
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


            function attachActivateEvent() {
                const activateLinks = document.querySelectorAll('.ancoreactivar');

                activateLinks.forEach(function(link) {
                    link.addEventListener('click', function(event) {
                        event.preventDefault();

                        const planId = this.getAttribute('data-id');
                        const confirmed = confirm('¿Estás seguro de que deseas reactivar este plan?');

                        if (confirmed) {
                            fetch('../Plantillas/activar_planes.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        id: planId
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        alert('Plan activado correctamente.');
                                    } else {
                                        alert('Error al activar el plan: ' + data.message);
                                    }
                                })
                                .catch(error => console.error('Error:', error));
                        } else {
                            console.log('Activación del plan cancelada.');
                        }
                    });
                });
            }

            // Attach event listeners for activating plans on initial load
            attachActivateEvent();

            // Attach event listeners for activating plans on every draw event
            table.on('draw', function() {
                attachActivateEvent();
            });

        });
    </script>






</body>