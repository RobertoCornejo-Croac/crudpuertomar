<?php
header('Content-Type: application/json');
require '../db.php';

try {
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (!$data) {
        throw new Exception('Datos JSON inválidos');
    }
    
    $nombre = trim($data['nombre']);
    $apellido = trim($data['apellido']);
    $nick = trim($data['nick']);
    $clave = $data['clave'];
    
    // Validaciones
    if (empty($nombre) || empty($apellido) || empty($nick) || empty($clave)) {
        throw new Exception('Todos los campos son requeridos');
    }
    
    // Verificar si el nick ya existe
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE nick = ?");
    $stmt->execute([$nick]);
    if ($stmt->fetch()) {
        throw new Exception('El nick de usuario ya existe');
    }
    
    // Cifrar la contraseña usando BCRYPT
    $clave_hash = password_hash($clave, PASSWORD_BCRYPT);
    
    // Insertar usuario
    $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, apellido, nick, clave) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nombre, $apellido, $nick, $clave_hash]);
    
    echo json_encode(['success' => true, 'message' => 'Usuario creado exitosamente']);
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error en la base de datos: ' . $e->getMessage()]);
}
?>
