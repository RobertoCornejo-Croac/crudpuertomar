<?php
header('Content-Type: application/json');
require '../db.php';

try {
    $id = $_POST['id'];
    
    if (empty($id)) {
        throw new Exception('ID de embarcación requerido');
    }
    
    // Verificar si la embarcación existe
    $stmt = $pdo->prepare("SELECT id FROM embarcaciones WHERE id = ?");
    $stmt->execute([$id]);
    if (!$stmt->fetch()) {
        throw new Exception('Embarcación no encontrada');
    }
    
    // Eliminar embarcación
    $stmt = $pdo->prepare("DELETE FROM embarcaciones WHERE id = ?");
    $stmt->execute([$id]);
    
    echo json_encode(['success' => true, 'message' => 'Embarcación eliminada exitosamente']);
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error en la base de datos: ' . $e->getMessage()]);
}
?> 