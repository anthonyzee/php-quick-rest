<?php
/**
 * index.php
 * Acts as a fallback router in the folder.
 * It will look for [endpoint].php in the same folder,
 * or fallback to default.php if not found.
 */
require_once __DIR__ . '/../utils/cors.php';

$requestUri = $_SERVER['REQUEST_URI'];
$path = parse_url($requestUri, PHP_URL_PATH);
$currentDir = dirname(__FILE__);
$endpoint = basename($path);

function send404() {
    http_response_code(404);
    echo json_encode(['error' => '404 Not Found']);
    exit;
}

if ($endpoint === '' || $endpoint === 'index.php') {
    $targetFile = $currentDir . '/default.php';
    if (file_exists($targetFile)) {
        require_once $targetFile;
    } else {
        send404();
    }
    exit;
}

$targetFile = $currentDir . '/' . $endpoint . '.php';

if (file_exists($targetFile)) {
    require_once $targetFile;
} else {
    $defaultFile = $currentDir . '/default.php';
    if (file_exists($defaultFile)) {
        require_once $defaultFile;
    } else {
        send404();
    }
}
