<?php
/**
 * Database Configuration
 * 
 * IMPORTANT: In production, these values should be loaded from environment variables
 * Use .env file and load with a library like vlucas/phpdotenv
 */

return [
    'host' => getenv('DB_HOST') ?: 'localhost',
    'database' => getenv('DB_DATABASE') ?: 'samyak',
    'username' => getenv('DB_USERNAME') ?: 'root',
    'password' => getenv('DB_PASSWORD') ?: '',
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
];
