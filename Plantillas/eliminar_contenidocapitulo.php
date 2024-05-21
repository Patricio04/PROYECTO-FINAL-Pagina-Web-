<?php
// Archivo de conexión a la BD
require '../Assets/Bases de datos/db.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id'])) {
    $idContenidoCapitulo = $data['id'];

    try {
        // Elimina el contenido del capítulo de la tabla contenidocapitulo
        $sql = "DELETE FROM ContenidoCapitulo WHERE IdContenido = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $idContenidoCapitulo);
        $stmt->execute();
        $stmt->close();

        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    } finally {
        $conn->close();
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID de contenido de capítulo no proporcionado.']);
}
?>
