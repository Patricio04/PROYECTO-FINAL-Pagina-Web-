

<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$database = "tatsu2"; 

// Crear una conexión
$conn = mysqli_connect($servername, $username, $password, $database);

// Verificar la conexión
if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}
echo "";
?>