
<?php
$serverName = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "tatsudatabase"; 

// Establecer conexión
$conn = mysqli_connect($serverName, $username, $password, $database);

// Verificar conexión
if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}

echo "Conexión establecida correctamente";
?>