<?php
/**
 * Application Entry Point
 * All requests are routed through this file
 */

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;
use App\Core\Session;

// Error handling
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

// Timezone
date_default_timezone_set('Asia/Kolkata');

// Initialize session
$session = Session::getInstance();

// Initialize router
$router = new Router();

// Define routes
// Public routes
$router->add('', ['controller' => 'home', 'action' => 'index']);
$router->add('index', ['controller' => 'home', 'action' => 'index']);
$router->add('about', ['controller' => 'home', 'action' => 'about']);
$router->add('aboutus', ['controller' => 'home', 'action' => 'about']);
$router->add('contact', ['controller' => 'home', 'action' => 'contact']);
$router->add('contact_us', ['controller' => 'home', 'action' => 'contact']);
$router->add('privacy-policy', ['controller' => 'home', 'action' => 'privacy']);
$router->add('terms', ['controller' => 'home', 'action' => 'terms']);
$router->add('faq', ['controller' => 'home', 'action' => 'faq']);

// Auth routes
$router->add('login', ['controller' => 'auth', 'action' => 'login']);
$router->add('authenticate', ['controller' => 'auth', 'action' => 'authenticate']);
$router->add('register', ['controller' => 'auth', 'action' => 'register']);
$router->add('register/store', ['controller' => 'auth', 'action' => 'store']);
$router->add('logout', ['controller' => 'auth', 'action' => 'logout']);
$router->add('forgot-password', ['controller' => 'auth', 'action' => 'forgotPassword']);

// Profile routes
$router->add('homepage', ['controller' => 'profile', 'action' => 'dashboard']);
$router->add('view-profile/{id:[a-zA-Z0-9]+}', ['controller' => 'profile', 'action' => 'view']);
$router->add('edit-profile', ['controller' => 'profile', 'action' => 'edit']);
$router->add('update-profile', ['controller' => 'profile', 'action' => 'update']);

// Search routes
$router->add('search', ['controller' => 'search', 'action' => 'index']);
$router->add('search_result', ['controller' => 'search', 'action' => 'results']);
$router->add('search-result', ['controller' => 'search', 'action' => 'results']);
$router->add('search-by-id', ['controller' => 'search', 'action' => 'byId']);

// Interest routes
$router->add('express-interest', ['controller' => 'interest', 'action' => 'send']);
$router->add('accept-interest', ['controller' => 'interest', 'action' => 'accept']);
$router->add('decline-interest', ['controller' => 'interest', 'action' => 'decline']);
$router->add('express_interest_received', ['controller' => 'interest', 'action' => 'received']);
$router->add('express_interest_sent', ['controller' => 'interest', 'action' => 'sent']);

// API routes (AJAX)
$router->add('api/castes', ['controller' => 'search', 'action' => 'getCastes']);
$router->add('api/cities', ['controller' => 'search', 'action' => 'getCities']);

// Dispatch
try {
    $url = $_SERVER['REQUEST_URI'] ?? '/';
    $url = parse_url($url, PHP_URL_PATH);
    $router->dispatch($url);
} catch (\Exception $e) {
    error_log($e->getMessage());
    
    if ($e->getCode() === 404) {
        http_response_code(404);
        include __DIR__ . '/../templates/errors/404.php';
    } else {
        http_response_code(500);
        include __DIR__ . '/../templates/errors/500.php';
    }
}
