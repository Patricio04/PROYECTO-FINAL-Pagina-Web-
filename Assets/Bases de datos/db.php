
<?php
$serverName = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "tatsudatabase"; 

$conn = mysqli_connect($serverName, $username, $password, $database);

if (!$conn) {
    die("<div class='alert alert-dismissible alert-danger' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 1000;'>
    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
    <strong>No se logró establecer conexion con la base de datos!</strong></div>" . mysqli_connect_error());
};
?>