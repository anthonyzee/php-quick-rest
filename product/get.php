<?php
// Load Composer autoloader (required when using vendor-installed packages)
// Make sure all require paths point to the /vendor directory
// require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../utils/cors.php';
require_once __DIR__ . '/../utils/jwt.php';
$auth_header = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
if (!preg_match('/Bearer\s(\S+)/', $auth_header, $matches)) {
  http_response_code(401);
  echo json_encode(['error' => 'Token missing']);
  exit;
}
try {
  $decoded = verify_jwt($matches[1]);
  echo json_encode(['message' => 'GET success', 'user' => $decoded->sub]);
} catch (Exception $e) {
  http_response_code(401);
  echo json_encode(['error' => 'Token invalid']);
}