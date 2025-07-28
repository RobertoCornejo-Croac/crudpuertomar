<?php
header('Content-Type: application/json');
require '../db.php';

try {
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (!$data) {
        throw new Exception('Datos JSON inválidos');
    }
    
    $id = $data['id'];
    $nombre = trim($data['nombre']);
    $apellido = trim($data['apellido']);
    $nick = trim($data['nick']);
    $clave = $data['clave'];
    
    // Validaciones
    if (empty($id) || empty($nombre) || empty($apellido) || empty($nick)) {
        throw new Exception('Los campos nombre, apellido y nick son requeridos');
    }
    
    // Verificar si el usuario existe
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE id = ?");
    $stmt->execute([$id]);
    if (!$stmt->fetch()) {
        throw new Exception('Usuario no encontrado');
    }
    
    // Verificar si el nick ya existe en otro usuario
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE nick = ? AND id != ?");
    $stmt->execute([$nick, $id]);
    if ($stmt->fetch()) {
        throw new Exception('El nick de usuario ya existe');
    }
    
    // Construir la consulta SQL
    if (!empty($clave)) {
        // Si se proporciona una nueva contraseña, actualizarla
        $clave_hash = password_hash($clave, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("UPDATE usuarios SET nombre = ?, apellido = ?, nick = ?, clave = ? WHERE id = ?");
        $stmt->execute([$nombre, $apellido, $nick, $clave_hash, $id]);
    } else {
        // Si no se proporciona contraseña, mantener la actual
        $stmt = $pdo->prepare("UPDATE usuarios SET nombre = ?, apellido = ?, nick = ? WHERE id = ?");
        $stmt->execute([$nombre, $apellido, $nick, $id]);
    }
    
    echo json_encode(['success' => true, 'message' => 'Usuario actualizado exitosamente']);
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error en la base de datos: ' . $e->getMessage()]);
}
?>
