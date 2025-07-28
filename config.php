<?php
// Configuración centralizada
class Config {
    // Detectar entorno
    public static function getEnvironment() {
        return getenv('ENVIRONMENT') ?: 'local';
    }
    
    // Configuración de base de datos
    public static function getDatabaseConfig() {
        $env = self::getEnvironment();
        
        if ($env === 'production') {
            return [
                'host' => getenv('DB_HOST') ?: 'localhost',
                'port' => getenv('DB_PORT') ?: '5432',
                'dbname' => getenv('DB_NAME') ?: 'crud_puertomar',
                'user' => getenv('DB_USER') ?: 'postgres',
                'password' => getenv('DB_PASSWORD') ?: ''
            ];
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