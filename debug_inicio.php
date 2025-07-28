<?php
header('Content-Type: application/json');
require 'db.php';

try {
    // Verificar si la tabla embarcaciones existe
    $stmt = $pdo->query("SELECT EXISTS (
        SELECT FROM information_schema.tables 
        WHERE table_schema = 'public' 
        AND table_name = 'embarcaciones'
    )");
    $existe = $stmt->fetchColumn();
    
    if (!$existe) {
        echo json_encode([
            'error' => 'La tabla embarcaciones no existe. Ejecuta el script SQL primero.',
            'debug' => 'Tabla no encontrada'
        ]);
        exit;
    }
    
    // Intentar obtener embarcaciones
    $stmt = $pdo->query("
        SELECT 
            e.id,
            e.nombre,
            e.ano_construccion,
            e.tipo_barco,
            e.capacidad_carga,
            e.usuario_id,
            e.fecha_creacion,
            CONCAT(u.nombre, ' ', u.apellido) as usuario_nombre,
            u.nick as usuario_nick
        FROM embarcaciones e
        LEFT JOIN usuarios u ON e.usuario_id = u.id
        ORDER BY e.id DESC
    ");
    $embarcaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'success' => true,
        'total' => count($embarcaciones),
        'embarcaciones' => $embarcaciones,
        'debug' => 'Consulta ejecutada correctamente'
    ]);
    
} catch (PDOException $e) {
    echo json_encode([
        'error' => 'Error en la base de datos: ' . $e->getMessage(),
        'debug' => 'Excepción PDO'
    ]);
} catch (Exception $e) {
    echo json_encode([
        'error' => 'Error general: ' . $e->getMessage(),
        'debug' => 'Excepción general'
    ]);
}
?> 