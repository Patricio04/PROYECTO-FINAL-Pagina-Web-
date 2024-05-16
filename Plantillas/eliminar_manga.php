<?php
// archivo de conexion a la BD
require '../Assets/Bases de datos/db.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id'])) {
    $idManga = $data['id'];

    // Inicia la transacción
    $conn->begin_transaction();

    try {
        // Elimina las etiquetas asociadas al manga
        $sql = "DELETE FROM EtiquetaManga WHERE IdManga = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idManga);
        $stmt->execute();

        // Elimina las visualizaciones asociadas al manga
        $sql = "DELETE FROM Visualizacion WHERE IdManga = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idManga);
        $stmt->execute();
        $stmt->close();

        // Elimina el manga
        $sql = "DELETE FROM Manga WHERE IdManga = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idManga);
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
    echo json_encode(['success' => false, 'message' => 'ID de manga no proporcionado.']);
}
?>
