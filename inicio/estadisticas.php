<?php
header('Content-Type: application/json');
require '../db.php';

try {
    // Obtener estadísticas de embarcaciones
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM embarcaciones");
    $total_embarcaciones = $stmt->fetchColumn();
    
    // Obtener estadísticas de usuarios
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM usuarios");
    $total_usuarios = $stmt->fetchColumn();
    
    echo json_encode([
        'total_embarcaciones' => $total_embarcaciones,
        'total_usuarios' => $total_usuarios
    ]);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error al obtener estadísticas: ' . $e->getMessage()]);
}
?> 