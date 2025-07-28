<?php
// Configuración 
$host = 'localhost'; // Usualmente es localhost
$port = '5432';
$dbname = 'tu_nombre_usuario_crud_puertomar'; // Formato: usuario_nombre_db
$user = 'tu_nombre_usuario'; // Tu usuario de 
$password = 'tu_contraseña_db'; // Contraseña de la base de datos

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error de conexión a la base de datos");
}
?> 