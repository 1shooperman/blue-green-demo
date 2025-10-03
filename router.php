<?php
// Simple router for PHP's built-in server so /health works without Apache/Nginx rewrites.
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($uri === '/health') {
    header('Content-Type: text/plain');
    http_response_code(200);
    echo 'ok';
    exit;
}

// Let the built-in server serve existing files (e.g., assets) if requested
$path = __DIR__ . '/public' . $uri;
if ($uri !== '/' && file_exists($path) && !is_dir($path)) {
    return false; // hand off to the built-in server
}

// Fallback to index for anything else (including "/")
require __DIR__ . '/public/index.php';
