<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$secret_key = 'your_secret_key';
$issuer = 'yourdomain.com';

function generate_jwt($username) {
  global $secret_key, $issuer;
  $issuedAt = time();
  $expiration = $issuedAt + 3600;
  $payload = ['iss' => $issuer, 'iat' => $issuedAt, 'exp' => $expiration, 'sub' => $username];
  return JWT::encode($payload, $secret_key, 'HS256');
}

function verify_jwt($token) {
  global $secret_key;
  return JWT::decode($token, new Key($secret_key, 'HS256'));
}