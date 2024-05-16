
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tatsu</title>
    <link rel="Stylesheet" href="../Styles/normalize.css" />
    <link rel="Stylesheet" href="../Styles/bootstrap.min.css" />

    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Honk&family=Rubik+Glitch+Pop&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Rubik+Glitch+Pop&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Silkscreen:wght@400;700&display=swap" rel="stylesheet">

</head>


<?php

session_start();
// Verificar si el usuario está autenticado

if (!isset($_SESSION['IdUsuario'])) {
    // El usuario no ha iniciado sesión, redirigirlo a la página de inicio de sesión
    header("Location: ../Index.php");
    exit();
}

// Si el usuario está autenticado, obtener el ID de usuario de la sesión
$id_usuario = $_SESSION['IdUsuario'];



if (isset($_GET['cerrar_sesion'])) {
    // Destruir todas las variables de sesión
    session_unset();

    // Destruir la sesión
    session_destroy();

    header("Location: ../index.php");
    exit();
}
?>