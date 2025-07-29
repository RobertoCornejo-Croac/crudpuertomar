<?php
require 'config.php';

$config = Config::getDatabaseConfig();

try {
    $pdo = new PDO(
        "pgsql:host={$config['host']};port={$config['port']};dbname={$config['dbname']}",
        $config['user'],
        $config['password']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'error' => 'Error en la conexión: ' . $e->getMessage()
    ]);
}
