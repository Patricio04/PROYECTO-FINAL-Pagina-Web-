<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tatsu</title>

    <link rel="Stylesheet" href="../Styles/bootstrap.min.css" />
    <link rel="Stylesheet" href="../Styles/normalize.css" />
    <link rel="Stylesheet" href="../Styles/index.css" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Honk&family=Rubik+Glitch+Pop&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Rubik+Glitch+Pop&display=swap"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Silkscreen:wght@400;700&display=swap" rel="stylesheet">

</head>

<?php
include '../Plantillas/Header.php';
?>
<main>


    <div class="container mt-4 ">
        <div class="row bg-dark p-4">
            <div class="col-lg-4">
                <ul class="nav nav-pills flex-column mb-auto">

                    <li class="nav-item mb-2">
                        <a class="nav-link active" href="#">Mi cuenta</a>
                    </li>

                    <li class="nav-item mb-2">
                        <a class="nav-link btn btn-outline-danger" href="#">Cerrar Sesión</a>
                    </li>
            </div>


            <div class="col-lg-8">
                <form method="post">
                    <i class="fas fa-gem me-3"></i><label class="form-label mb-3">Datos de usuario</label>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingLastname" name="nombre"
                            placeholder="name@example.com">
                        <label>Nombres</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingLastname" name="apellido"
                            placeholder="name@example.com">
                        <label>Apellidos</label>
                    </div>
                    <div class="form-floating mb-3 ">
                        <input type="mail" class="form-control" id="floatingEmail" name="correo"
                            placeholder="name@example.com">
                        <label>Correo electronico</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="floatingPassword" name="contraseña"
                            placeholder="Password" autocomplete="off">
                        <label>Contraseña</label>
                    </div>
                    <button type="submit" class="btn btn-outline-primary">Guardar cambios</button>

                </form>


            </div>

        </div>

    </div>

    <?php
    include '../Plantillas/Footer.php';
    ?>


</main>