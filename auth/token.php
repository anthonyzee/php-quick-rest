<?php
require_once __DIR__ . '/../utils/cors.php';
require_once __DIR__ . '/../utils/jwt.php';

$auth_users = [
  'admin' => '$2y$10$/K.hjNr84lLNDt8fTXjoI.DBp6PpeyoJ.mGwrrLuCZfAwfSAGqhOW',
  'user' => '$2y$10$Fg6Dz8oH9fPoZ2jJan5tZuv6Z4Kp7avtQ9bDfrdRntXtPeiMAZyGO'
];

$username = $_SERVER['HTTP_USERNAME'] ?? '';
$password = $_SERVER['HTTP_PASSWORD'] ?? '';

if (!isset($auth_users[$username]) || !password_verify($password, $auth_users[$username])) {
  http_response_code(401);
  echo json_encode(['error' => 'Invalid username or password']);
  exit;
}

echo json_encode(['token' => generate_jwt($username), 'expires_in' => 3600]);