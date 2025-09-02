<?php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'golocal_db');
define('DB_USER', 'root');
define('DB_PASS', ''); // Change this to your MySQL password

// Application Configuration
define('BASE_URL', 'http://localhost/GoLocal/public'); // Updated this line
define('APP_NAME', 'GoLocal');
define('APP_VERSION', '1.0.0');

// Security
define('SESSION_TIMEOUT', 3600); // 1 hour
define('HASH_ALGO', PASSWORD_DEFAULT);

// Paths
define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');
define('PUBLIC_PATH', ROOT_PATH . '/public');
define('VIEW_PATH', APP_PATH . '/views');

// Error reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session
session_start();
?>