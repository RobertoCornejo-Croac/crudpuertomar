<?php
require 'config.php';

$config = Config::getDatabaseConfig();

header('Content-Type: application/json');
echo json_encode([
    'env' => Config::getEnvironment(),
    'config' => $config,
    'php_getenv' => getenv('DB_HOST'),
    'php_env' => $_ENV['DB_HOST'] ?? null
]);
