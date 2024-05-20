<?php
// archivo de conexión a la BD
require '../Assets/Bases de datos/db.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id'])) {
    $idPlan = $data['id'];

    // Inicia la transacción
    $conn->begin_transaction();

    try {
        // Desactivar el plan en lugar de eliminarlo
        $sql = "UPDATE Planes SET Activo = 1 WHERE IdPlan = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idPlan);
        $stmt->execute();

        // Confirma la transacción
        $conn->commit();

        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        // Si ocurre un error, deshace la transacción
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    } finally {
        $stmt->close();
        $conn->close();
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID de plan no proporcionado.']);
}
?>