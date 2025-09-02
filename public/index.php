<?php
// GoLocal Entry Point
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

// Get the current URI
$uri = $_SERVER['REQUEST_URI'];
$uri = str_replace('/GoLocal/public', '', $uri); // Remove base path
$uri = trim($uri, '/');

// Dispatch the request
try {
    $router->dispatch($uri);
} catch (Exception $e) {
    // Error handling
    http_response_code(500);
    echo "500 - Internal Server Error: " . $e->getMessage();
}
?>