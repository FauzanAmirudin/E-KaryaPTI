<?php

/**
 * CodeIgniter PHP-Development Server Rewrite Rules
 *
 * This script works with the built-in PHP web server to route all requests
 * to CodeIgniter's front controller (index.php).
 */

// Define the full path to the document root
$publicPath = __DIR__ . DIRECTORY_SEPARATOR . 'public';

// Parse the URI
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Ensure we are in the public directory
chdir($publicPath);

// Process the request
// If the file exists, return false (let the server respond normally)
// Otherwise, load the index.php file
$requested = $publicPath . DIRECTORY_SEPARATOR . ltrim($uri, '/');

if ($uri !== '/' && file_exists($requested)) {
    return false;
} else {
    // Include the front controller
    require_once $publicPath . DIRECTORY_SEPARATOR . 'index.php';
} 