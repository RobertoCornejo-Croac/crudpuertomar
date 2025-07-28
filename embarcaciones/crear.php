<?php
header('Content-Type: application/json');
require '../db.php';

try {
    // Obtener datos del formulario
    $nombre = trim($_POST['nombre']);
    $ano_construccion = (int)$_POST['ano_construccion'];
    $tipo_barco = trim($_POST['tipo_barco']);
    $capacidad_carga = (float)$_POST['capacidad_carga'];
    $usuario_id = !empty($_POST['usuario_id']) ? (int)$_POST['usuario_id'] : null;
    
    // Validaciones
    if (empty($nombre) || empty($ano_construccion) || empty($tipo_barco) || empty($capacidad_carga)) {
        throw new Exception('Todos los campos son requeridos');
    }
    
    if ($ano_construccion < 1900 || $ano_construccion > date('Y')) {
        throw new Exception('Año de construcción inválido');
    }
    
    if ($capacidad_carga <= 0) {
        throw new Exception('La capacidad de carga debe ser mayor a 0');
    }
    
    // Verificar si el usuario existe 
    if ($usuario_id) {
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE id = ?");
        $stmt->execute([$usuario_id]);
        if (!$stmt->fetch()) {
            throw new Exception('El usuario seleccionado no existe');
        }
    }
    
    // Manejar subida de foto
    $foto_path = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['foto'];
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_size = 2 * 1024 * 1024; // 2MB
        
        // Validar tipo de archivo
        if (!in_array($file['type'], $allowed_types)) {
            throw new Exception('Tipo de archivo no permitido. Solo JPG, PNG y GIF');
        }
        
        // Validar tamaño
        if ($file['size'] > $max_size) {
            throw new Exception('El archivo es demasiado grande. Máximo 2MB');
        }
        
        // Generar nombre único
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $extension;
        $upload_path = '../fotos/' . $filename;
        
        // Mover archivo
        if (move_uploaded_file($file['tmp_name'], $upload_path)) {
            $foto_path = 'fotos/' . $filename;
        } else {
            throw new Exception('Error al subir la imagen');
        }
    }
    
    // Insertar embarcación
    $stmt = $pdo->prepare("INSERT INTO embarcaciones (nombre, ano_construccion, tipo_barco, capacidad_carga, usuario_id, foto) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nombre, $ano_construccion, $tipo_barco, $capacidad_carga, $usuario_id, $foto_path]);
    
    echo json_encode(['success' => true, 'message' => 'Embarcación creada exitosamente']);
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error en la base de datos: ' . $e->getMessage()]);
}
?> 