<?php
// Configuración centralizada
class Config {
    // Detectar entorno
public static function getDatabaseConfig() {
    $env = self::getEnvironment();

    if ($env === 'production') {
        $host = getenv('DB_HOST') ?: $_ENV['DB_HOST'] ?? 'dpg-d240o8re5dus73b681tg-a';
        $port = getenv('DB_PORT') ?: $_ENV['DB_PORT'] ?? '5432';
        $dbname = getenv('DB_NAME') ?: $_ENV['DB_NAME'] ?? 'crud_puertomar';
        $user = getenv('DB_USER') ?: $_ENV['DB_USER'] ?? 'crud_puertomar_user';
        $password = getenv('DB_PASSWORD') ?: $_ENV['DB_PASSWORD'] ?? 'R6AiYKWfGIWYTlFYe3Gzaa8yHP5XE42L';

        return compact('host', 'port', 'dbname', 'user', 'password');
    } else {
        return [
            'host' => 'localhost',
            'port' => '5432',
            'dbname' => 'crud_puertomar',
            'user' => 'postgres',
            'password' => 'Bonnie123'
        ];
    }
}
    
    // Configuración de errores
    public static function isProduction() {
        return self::getEnvironment() === 'production';
    }
    
    // Configuración de debug
    public static function isDebugEnabled() {
        return !self::isProduction();
    }
    
    // Configuración de CORS (si es necesario)
    public static function getCorsHeaders() {
        if (self::isProduction()) {
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
            header('Access-Control-Allow-Headers: Content-Type, Authorization');
        }
    }
}
?> 
