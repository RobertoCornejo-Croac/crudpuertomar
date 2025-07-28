<?php
// Configuración para diferentes entornos
$environment = getenv('ENVIRONMENT') ?: 'local';

if ($environment === 'production') {
    // Configuración para servidor de producción
    $host = getenv('DB_HOST') ?: 'localhost';
    $port = getenv('DB_PORT') ?: '5432';
    $dbname = getenv('DB_NAME') ?: 'crud_puertomar';
    $user = getenv('DB_USER') ?: 'postgres';
    $password = getenv('DB_PASSWORD') ?: '';
} else {
    // Configuración local
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
    // En producción, no mostrar detalles del error
    if ($environment === 'production') {
        die("Error de conexión a la base de datos");
    } else {
        die("Error en la conexión: " . $e->getMessage());
    }
}
?>
