<?php
require '../Assets/Bases de datos/db.php';

// Obtener los datos enviados en el cuerpo de la solicitud
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id'])) {
    $usuarioId = $data['id'];

    // Iniciar una transacción
    $conn->begin_transaction();

    try {
        // Eliminar de la tabla Favorito
        $sql = "DELETE FROM Favorito WHERE IdUsuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $usuarioId);
        $stmt->execute();
        $stmt->close();

        // Eliminar de la tabla Tarjeta
        $sql = "DELETE FROM Tarjeta WHERE IdUsuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $usuarioId);
        $stmt->execute();
        $stmt->close();

        // Eliminar de la tabla Suscripcion
        $sql = "DELETE FROM Suscripcion WHERE IdUsuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $usuarioId);
        $stmt->execute();
        $stmt->close();

        // Eliminar de la tabla Comentario
        $sql = "DELETE FROM Comentario WHERE IdUsuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $usuarioId);
        $stmt->execute();
        $stmt->close();

        // Eliminar de la tabla Visualizacion
        $sql = "DELETE FROM Visualizacion WHERE IdUsuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $usuarioId);
        $stmt->execute();
        $stmt->close();

        // Finalmente, eliminar de la tabla Usuario
        $sql = "DELETE FROM Usuario WHERE IdUsuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $usuarioId);
        $stmt->execute();
        $stmt->close();

        // Si todas las eliminaciones fueron exitosas, confirmar la transacción
        $conn->commit();
        echo json_encode(["success" => true]);
    } catch (Exception $e) {
        // Si ocurrió algún error, deshacer la transacción
        $conn->rollback();
        echo json_encode(["success" => false, "message" => "Error al eliminar el usuario: " . $e->getMessage()]);
    }

} else {
    echo json_encode(["success" => false, "message" => "ID de usuario no proporcionado."]);
}

$conn->close();
?>
