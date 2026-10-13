<?php
/**
 * Entry Point - Mini Social Network API
 * Author: Mohammed AICHOUR
 */

// Enable CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Content-Type: application/json; charset=UTF-8");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Simple PSR-4 style autoloader
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    // lowercase first dir if needed
    $parts = explode('/', str_replace('\\', '/', $relative_class));
    if (count($parts) > 1) {
        $parts[0] = strtolower($parts[0]);
        $altFile = $base_dir . implode('/', $parts) . '.php';
        if (file_exists($altFile)) {
            require $altFile;
            return;
        }
    }

    if (file_exists($file)) {
        require $file;
    }
});

// Load Router
$router = require __DIR__ . '/routes/api.php';

// Parse Path
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Dispatch
$router($method, $uri);
