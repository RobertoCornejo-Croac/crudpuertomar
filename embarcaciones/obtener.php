<?php
header('Content-Type: application/json');
require '../db.php';

try {
    $id = $_POST['id'];
    
    if (empty($id)) {
        throw new Exception('ID de embarcación requerido');
    }
    
    // Obtener datos de la embarcación
    $stmt = $pdo->prepare("
        SELECT 
            e.id,
            e.nombre,
            e.ano_construccion,
            e.tipo_barco,
            e.capacidad_carga,
            e.usuario_id,
            e.foto
        FROM embarcaciones e
        WHERE e.id = ?
    ");
    $stmt->execute([$id]);
    $embarcacion = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$embarcacion) {
        throw new Exception('Embarcación no encontrada');
    }
    
    echo json_encode(['success' => true, 'embarcacion' => $embarcacion]);
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error en la base de datos: ' . $e->getMessage()]);
}
?> 