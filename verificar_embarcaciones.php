<?php
header('Content-Type: application/json');
require 'db.php';

try {
    // Verificar si la tabla existe
    $stmt = $pdo->query("SELECT EXISTS (
        SELECT FROM information_schema.tables 
        WHERE table_schema = 'public' 
        AND table_name = 'embarcaciones'
    )");
    $tabla_existe = $stmt->fetchColumn();
    
    if (!$tabla_existe) {
        echo json_encode([
            'error' => 'La tabla embarcaciones NO existe',
            'solucion' => 'Ejecuta el script SQL en pgAdmin'
        ]);
        exit;
    }
    
    // Contar registros
    $stmt = $pdo->query("SELECT COUNT(*) FROM embarcaciones");
    $total = $stmt->fetchColumn();
    
    // Obtener algunos registros de ejemplo
    $stmt = $pdo->query("SELECT id, nombre, tipo_barco FROM embarcaciones LIMIT 3");
    $ejemplos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'success' => true,
        'tabla_existe' => true,
        'total_embarcaciones' => $total,
        'ejemplos' => $ejemplos,
        'mensaje' => $total > 0 ? 'La tabla existe y tiene datos' : 'La tabla existe pero está vacía'
    ]);
    
} catch (PDOException $e) {
    echo json_encode([
        'error' => 'Error en la base de datos: ' . $e->getMessage()
    ]);
}
?> 