<?php
/**
 * PHP Built-in Server Router
 * This file routes all requests through index.php
 */

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// If the file physically exists (CSS, JS, images), serve it directly
if ($requestUri !== '/' && file_exists(__DIR__ . $requestUri)) {
    return false; // Let PHP serve the static file
}

// Otherwise, route everything through index.php
require_once __DIR__ . '/index.php';
