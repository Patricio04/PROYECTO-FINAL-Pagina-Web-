<?php
// Archivo de conexión a la BD
require '../Assets/Bases de datos/db.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id'])) {
    $idCapitulo = $data['id'];

    // Inicia la transacción
    $conn->begin_transaction();

    try {
        // Elimina el contenido del capítulo de la tabla contenidocapitulo
        $sql = "DELETE FROM contenidocapitulo WHERE IdCapitulo = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idCapitulo);
        $stmt->execute();
        $stmt->close();

        // Elimina el capítulo
        $sql = "DELETE FROM Capitulo WHERE IdCapitulo = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idCapitulo);
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
    echo json_encode(['success' => false, 'message' => 'ID de capítulo no proporcionado.']);
}
?>
