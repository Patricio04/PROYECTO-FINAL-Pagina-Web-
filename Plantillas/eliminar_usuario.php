<?php
require '../Assets/Bases de datos/db.php';

// Obtener los datos enviados en el cuerpo de la solicitud
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id'])) {
    $usuarioId = $data['id'];

    // Preparar la consulta SQL para eliminar el usuario
    $sql = "DELETE FROM Usuario WHERE IdUsuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuarioId);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al eliminar el usuario."]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "ID de usuario no proporcionado."]);
}

$conn->close();
?>
