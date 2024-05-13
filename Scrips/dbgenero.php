<?php

require __DIR__ . '/../Assets/Bases de datos/db.php';



if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Consultar los géneros desde la base de datos
$sql = "SELECT IdEtiqueta, NombreEtiqueta FROM etiqueta";
$resultado = mysqli_query($conn, $sql);

// Verificar si se encontraron resultados
if (mysqli_num_rows($resultado) > 0) {

    $generos = array();

   
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $genero = array(
            'id' => $fila['IdEtiqueta'],
            'nombre' => $fila['NombreEtiqueta']
        );
        $generos[] = $genero;
    }

    // Devolver los resultados como JSON
    header('Content-Type: application/json');
    echo json_encode($generos);
} else {
    // Si no se encontraron géneros, devolver un mensaje de error
    echo json_encode(array('error' => 'No se encontraron géneros en la base de datos.'));
}

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>