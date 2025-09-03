<?php
// GoLocal Entry Point - Updated for Sprint 2
require_once '../config/config.php';
require_once APP_PATH . '/core/Database.php';
require_once APP_PATH . '/core/Session.php';
require_once APP_PATH . '/core/Router.php';

// Initialize session
Session::start();

// Initialize router
$router = new Router();

// Define routes
$router->addRoute('', 'HomeController', 'index');
$router->addRoute('home', 'HomeController', 'index');
$router->addRoute('home/index', 'HomeController', 'index');
$router->addRoute('home/about', 'HomeController', 'about');

// Auth routes
$router->addRoute('auth/login', 'AuthController', 'login');
$router->addRoute('auth/register', 'AuthController', 'register');
$router->addRoute('auth/logout', 'AuthController', 'logout');

// Event routes - Sprint 2
$router->addRoute('events', 'EventController', 'index');
$router->addRoute('events/index', 'EventController', 'index');
$router->addRoute('events/search', 'EventController', 'search');
$router->addRoute('events/getByCity', 'EventController', 'getByCity');
$router->addRoute('events/getFeatured', 'EventController', 'getFeatured');

// Get the current URI and clean it
$uri = $_SERVER['REQUEST_URI'];

// Remove the base path
$basePath = '/GoLocal/public';
if (strpos($uri, $basePath) === 0) {
    $uri = substr($uri, strlen($basePath));
}

// Remove query string
$uri = strtok($uri, '?');
$uri = trim($uri, '/');

// Handle event show route with dynamic ID
if (strpos($uri, 'events/show/') === 0) {
    $router->addRoute($uri, 'EventController', 'show');
}

// Dispatch the request
try {
    $router->dispatch($uri);
} catch (Exception $e) {
    // Error handling
    http_response_code(500);
    echo "500 - Internal Server Error: " . $e->getMessage();
}
?>