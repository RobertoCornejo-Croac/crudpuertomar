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
    
    if ($existe) {
        // Contar registros
        $stmt = $pdo->query("SELECT COUNT(*) FROM embarcaciones");
        $total = $stmt->fetchColumn();
        
        echo json_encode([
            'success' => true,
            'message' => 'Tabla embarcaciones existe',
            'total_embarcaciones' => $total
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'La tabla embarcaciones no existe. Ejecuta el script SQL primero.'
        ]);
    }
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Error en la base de datos: ' . $e->getMessage()
    ]);
}
?> 