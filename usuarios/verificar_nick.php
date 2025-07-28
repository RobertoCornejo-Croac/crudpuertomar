<?php
header('Content-Type: application/json');
require '../db.php';

try {
    $nick = trim($_POST['nick']);
    
    if (empty($nick)) {
        throw new Exception('Nick de usuario requerido');
    }
    
    // Verificar si el nick ya existe
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE nick = ?");
    $stmt->execute([$nick]);
    $existe = $stmt->fetch() ? true : false;
    
    echo json_encode(['existe' => $existe]);
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error en la base de datos: ' . $e->getMessage()]);
}
?> 