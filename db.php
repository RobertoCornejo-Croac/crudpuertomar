<?php
putenv('ENVIRONMENT=production');
// Detectar entorno
$environment = getenv('ENVIRONMENT') ?: $_ENV['ENVIRONMENT'] ?? 'local';

if ($environment === 'production') {
    $host = getenv('DB_HOST') ?: $_ENV['DB_HOST'] ?? 'dpg-d240o8re5dus73b681tg-a';
    $port = getenv('DB_PORT') ?: $_ENV['DB_PORT'] ?? '5432';
    $dbname = getenv('DB_NAME') ?: $_ENV['DB_NAME'] ?? 'crud_puertomar';
    $user = getenv('DB_USER') ?: $_ENV['DB_USER'] ?? 'crud_puertomar_user';
    $password = getenv('DB_PASSWORD') ?: $_ENV['DB_PASSWORD'] ?? 'R6AiYKWfGIWYTlFYe3Gzaa8yHP5XE42L';
} else {
    $host = 'localhost';
    $port = '5432';
    $dbname = 'crud_puertomar';
    $user = 'postgres';
    $password = 'Bonnie123';
}

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'error' => $environment === 'production'
            ? 'Error de conexión a la base de datos'
            : 'Error en la conexión: ' . $e->getMessage()
    ]);
    exit;
}
?>
