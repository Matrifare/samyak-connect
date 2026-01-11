<?php
/**
 * Composer Autoloader Configuration
 */

spl_autoload_register(function ($class) {
    // Project namespace prefix
    $prefix = 'App\\';
    
    // Base directory for namespace prefix
    $baseDir = __DIR__ . '/app/';
    
    // Check if class uses our namespace
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    
    // Get relative class name
    $relativeClass = substr($class, $len);
    
    // Build file path
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
    
    // Load file if exists
    if (file_exists($file)) {
        require $file;
    }
});
