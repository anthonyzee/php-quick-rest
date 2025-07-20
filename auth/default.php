<?php
header('Content-Type: text/html');
http_response_code(200);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>PHP Quick REST – Default Response</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f4f4;
      color: #333;
      padding: 2rem;
      text-align: center;
    }
    .container {
      background: white;
      border-radius: 10px;
      padding: 2rem;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      max-width: 600px;
      margin: 4rem auto;
    }
    h1 {
      color: #007acc;
    }
    code {
      background: #eee;
      padding: 0.2rem 0.5rem;
      border-radius: 4px;
      font-family: monospace;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Welcome to PHP Quick REST</h1>
    <p>This is the <code>default.php</code> fallback for this route.</p>
    <p>If you intended to access a specific endpoint, make sure the file like <code>get.php</code>, <code>post.php</code> or other exists in this folder.</p>
    <p>To test JWT-protected routes, use a valid token with the <code>Authorization</code> header.</p>
  </div>
</body>
</html>
