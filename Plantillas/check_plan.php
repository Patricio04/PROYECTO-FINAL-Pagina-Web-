<?php
include '../Assets/Bases de datos/db.php';



$response = array('premium' => false);

$sql_check = "SELECT IdPlan FROM Usuario WHERE IdUsuario = ?";
if ($stmt_check = $conn->prepare($sql_check)) {
    $stmt_check->bind_param("i", $id_usuario);
    $stmt_check->execute();
    $stmt_check->bind_result($plan_id);
    $stmt_check->fetch();
    $stmt_check->close();

    if ($plan_id != 1) {
        $response['premium'] = true;
    }
}

// Cerrar la conexión
$conn->close();

// Devolver la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);
?>