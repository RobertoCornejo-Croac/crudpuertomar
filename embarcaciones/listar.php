<?php
header('Content-Type: application/json');
require '../db.php';

try {
    $stmt = $pdo->query("
        SELECT 
            e.id,
            e.nombre,
            e.ano_construccion,
            e.tipo_barco,
            e.capacidad_carga,
            e.usuario_id,
            e.fecha_creacion,
            e.foto,
            CONCAT(u.nombre, ' ', u.apellido) as usuario_nombre,
            u.nick as usuario_nick
        FROM embarcaciones e
        LEFT JOIN usuarios u ON e.usuario_id = u.id
        ORDER BY e.id DESC
    ");
    $embarcaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($embarcaciones);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error al obtener embarcaciones: ' . $e->getMessage()]);
}
?> 