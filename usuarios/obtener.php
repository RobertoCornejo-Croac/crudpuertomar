<?php
header('Content-Type: application/json');
require '../db.php';

try {
    $id = $_POST['id'];
    
    if (empty($id)) {
        throw new Exception('ID de usuario requerido');
    }
    
    // Obtener datos del usuario
    $stmt = $pdo->prepare("SELECT id, nombre, apellido, nick FROM usuarios WHERE id = ?");
    $stmt->execute([$id]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$usuario) {
        throw new Exception('Usuario no encontrado');
    }
    
    echo json_encode(['success' => true, 'usuario' => $usuario]);
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error en la base de datos: ' . $e->getMessage()]);
}
?> 