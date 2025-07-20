<?php
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
  $data = json_decode(file_get_contents('php://input'), true);
  echo json_encode(['message' => 'POST success', 'user' => $decoded->sub, 'data' => $data]);
} catch (Exception $e) {
  http_response_code(401);
  echo json_encode(['error' => 'Token invalid']);
}