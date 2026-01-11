<?php
/**
 * Application Configuration
 */

return [
    'name' => 'Samyak Matrimony',
    'url' => getenv('APP_URL') ?: 'https://www.samyakmatrimony.com',
    'timezone' => 'Asia/Kolkata',
    'debug' => getenv('APP_DEBUG') ?: false,
    
    // Session configuration
    'session' => [
        'lifetime' => 120, // minutes
        'expire_on_close' => false,
    ],
    
    // Upload configuration
    'upload' => [
        'max_size' => 5 * 1024 * 1024, // 5MB
        'allowed_extensions' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
        'path' => __DIR__ . '/../uploads/',
    ],
    
    // Mail configuration
    'mail' => [
        'from_email' => getenv('MAIL_FROM') ?: 'info@samyakmatrimony.com',
        'from_name' => 'Samyak Matrimony',
    ],
    
    // Pagination
    'pagination' => [
        'per_page' => 20,
    ],
];
