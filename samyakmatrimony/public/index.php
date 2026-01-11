<?php
/**
 * Samyak Matrimony - Application Entry Point
 * All requests are routed through this file
 */

// Enable error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../logs/error.log');

// Timezone
date_default_timezone_set('Asia/Kolkata');

// Autoloader
require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;
use App\Core\Session;

// Start session
$session = Session::getInstance();

// Initialize router
$router = new Router();

// ==========================================
// Define Routes
// ==========================================

// Public pages
$router->add('', ['controller' => 'home', 'action' => 'index']);
$router->add('index', ['controller' => 'home', 'action' => 'index']);
$router->add('about', ['controller' => 'home', 'action' => 'about']);
$router->add('aboutus', ['controller' => 'home', 'action' => 'about']);
$router->add('about-us', ['controller' => 'home', 'action' => 'about']);
$router->add('contact', ['controller' => 'home', 'action' => 'contact']);
$router->add('contact-us', ['controller' => 'home', 'action' => 'contact']);
$router->add('contact_us', ['controller' => 'home', 'action' => 'contact']);
$router->add('privacy-policy', ['controller' => 'home', 'action' => 'privacy']);
$router->add('terms', ['controller' => 'home', 'action' => 'terms']);
$router->add('faq', ['controller' => 'home', 'action' => 'faq']);

// Authentication
$router->add('login', ['controller' => 'auth', 'action' => 'login']);
$router->add('authenticate', ['controller' => 'auth', 'action' => 'authenticate']);
$router->add('register', ['controller' => 'auth', 'action' => 'register']);
$router->add('register/store', ['controller' => 'auth', 'action' => 'store']);
$router->add('logout', ['controller' => 'auth', 'action' => 'logout']);
$router->add('forgot-password', ['controller' => 'auth', 'action' => 'forgotPassword']);
$router->add('reset-password', ['controller' => 'auth', 'action' => 'resetPassword']);

// Dashboard & Profile
$router->add('homepage', ['controller' => 'profile', 'action' => 'dashboard']);
$router->add('dashboard', ['controller' => 'profile', 'action' => 'dashboard']);
$router->add('view-profile/{id:[a-zA-Z0-9]+}', ['controller' => 'profile', 'action' => 'view']);
$router->add('edit-profile', ['controller' => 'profile', 'action' => 'edit']);
$router->add('update-profile', ['controller' => 'profile', 'action' => 'update']);
$router->add('my-matches', ['controller' => 'profile', 'action' => 'matches']);
$router->add('change-password', ['controller' => 'profile', 'action' => 'changePassword']);
$router->add('profile-settings', ['controller' => 'profile', 'action' => 'settings']);

// Search
$router->add('search', ['controller' => 'search', 'action' => 'index']);
$router->add('search-result', ['controller' => 'search', 'action' => 'results']);
$router->add('search_result', ['controller' => 'search', 'action' => 'results']);
$router->add('search-by-id', ['controller' => 'search', 'action' => 'byId']);
$router->add('quick-search', ['controller' => 'search', 'action' => 'quick']);

// Interests
$router->add('express-interest', ['controller' => 'interest', 'action' => 'send']);
$router->add('accept-interest', ['controller' => 'interest', 'action' => 'accept']);
$router->add('decline-interest', ['controller' => 'interest', 'action' => 'decline']);
$router->add('express_interest_received', ['controller' => 'interest', 'action' => 'received']);
$router->add('express_interest_sent', ['controller' => 'interest', 'action' => 'sent']);
$router->add('interests-received', ['controller' => 'interest', 'action' => 'received']);
$router->add('interests-sent', ['controller' => 'interest', 'action' => 'sent']);

// Shortlist
$router->add('shortlist', ['controller' => 'shortlist', 'action' => 'index']);
$router->add('add-shortlist', ['controller' => 'shortlist', 'action' => 'add']);
$router->add('remove-shortlist', ['controller' => 'shortlist', 'action' => 'remove']);
$router->add('who-shortlisted-me', ['controller' => 'shortlist', 'action' => 'shortlistedMe']);

// Messages
$router->add('inbox', ['controller' => 'message', 'action' => 'inbox']);
$router->add('sent-messages', ['controller' => 'message', 'action' => 'sent']);
$router->add('messages', ['controller' => 'message', 'action' => 'conversation']);
$router->add('send-message', ['controller' => 'message', 'action' => 'send']);

// Profile Views
$router->add('who-viewed-me', ['controller' => 'profile', 'action' => 'viewers']);
$router->add('profiles-viewed', ['controller' => 'profile', 'action' => 'viewed']);

// Photos
$router->add('edit-photo', ['controller' => 'photo', 'action' => 'edit']);
$router->add('upload-photo', ['controller' => 'photo', 'action' => 'upload']);
$router->add('delete-photo', ['controller' => 'photo', 'action' => 'delete']);

// API Routes (AJAX)
$router->add('api/castes', ['controller' => 'api', 'action' => 'getCastes']);
$router->add('api/cities', ['controller' => 'api', 'action' => 'getCities']);
$router->add('api/check-email', ['controller' => 'api', 'action' => 'checkEmail']);
$router->add('api/check-mobile', ['controller' => 'api', 'action' => 'checkMobile']);

// ==========================================
// Dispatch Request
// ==========================================
try {
    $url = $_SERVER['REQUEST_URI'] ?? '/';
    $url = parse_url($url, PHP_URL_PATH);
    $router->dispatch($url);
} catch (\Exception $e) {
    error_log("Router Error: " . $e->getMessage());
    
    $code = $e->getCode() ?: 500;
    http_response_code($code);
    
    if ($code === 404) {
        include __DIR__ . '/../templates/errors/404.php';
    } else {
        include __DIR__ . '/../templates/errors/500.php';
    }
}
