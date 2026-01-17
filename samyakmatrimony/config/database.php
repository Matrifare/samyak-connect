<?php
/**
 * Database Configuration
 * 
 * For production, create config/database.local.php with your credentials
 */

// Load local config if exists
$localConfig = __DIR__ . '/database.local.php';
if (file_exists($localConfig)) {
    return require $localConfig;
}

return [
    'host' => getenv('DB_HOST') ?: 'localhost',
    'database' => getenv('DB_DATABASE') ?: 'samyakm1_samyakmatrimony_samyak',
    'username' => getenv('DB_USERNAME') ?: 'samyakm1_bigrock',
    'password' => getenv('DB_PASSWORD') ?: 'TdPLXV+eR$d%',
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
];
