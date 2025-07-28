<?php
header('Content-Type: application/json');

$host = 'localhost';
$port = '5432';
$dbname = 'crud_puertomar';
$user = 'postgres';
$password = 'Bonnie123';

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Probar consulta
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM usuarios");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'success' => true,
        'message' => 'Conexión exitosa',
        'total_usuarios' => $result['total']
    ]);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Error en la conexión: ' . $e->getMessage()
    ]);
}
?> 