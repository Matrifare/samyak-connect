<?php
/**
 * Application Configuration
 */

return [
    'name' => 'Samyak Matrimony',
    'tagline' => "India's #1 Buddhist Matrimony",
    'url' => getenv('APP_URL') ?: 'https://samyakmatrimony.com',
    'timezone' => 'Asia/Kolkata',
    'debug' => getenv('APP_DEBUG') ?: false,
    
    // Session settings
    'session' => [
        'name' => 'samyak_session',
        'lifetime' => 7200, // 2 hours
        'idle_timeout' => 1800, // 30 minutes
    ],
    
    // Upload settings
    'uploads' => [
        'max_size' => 5 * 1024 * 1024, // 5MB
        'allowed_types' => ['image/jpeg', 'image/png', 'image/gif', 'image/webp'],
        'photo_path' => 'uploads/photos/',
    ],
    
    // Pagination
    'pagination' => [
        'per_page' => 20,
    ],
    
    // Contact info
    'contact' => [
        'email' => 'info@samyakmatrimony.com',
        'phone' => '+91 XXXXXXXXXX',
        'address' => 'India',
    ],
];
