# php-quick-rest

A lightweight modular REST API framework in vanilla PHP, supporting JWT authentication, folder-based routing, and automatic fallback to `default.php` for missing endpoints.

🔗 GitHub: [https://github.com/anthonyzee/php-quick-rest](https://github.com/anthonyzee/php-quick-rest)

---

## 🚀 Features

- 📁 Folder-based REST structure (like `/auth`, `/product`)
- 🛡️ JWT authentication with token generation
- 🔄 Fallback routing to `default.php` if endpoint not found
- 🌍 CORS support for cross-origin requests
- ✅ Composer integration using `firebase/php-jwt`

---

## 📁 Project Structure

```
php-quick-rest/
├── auth/
│   ├── index.php          # Fallback router
│   ├── token.php          # Login with JWT
│   └── default.php        # Fallback if endpoint missing
├── product/
│   ├── index.php
│   ├── get.php
│   ├── post.php
│   ├── put.php
│   ├── delete.php
│   └── default.php
├── utils/
│   ├── cors.php           # Handles CORS and OPTIONS
│   └── jwt.php            # JWT encode/decode helpers
├── vendor/                # Composer dependencies
├── .htaccess              # Apache rewrite rule
├── composer.json
└── README.md
```

---

## ⚙️ Apache Setup

Each REST module folder (like `auth/`, `product/`) uses an `.htaccess` to route all requests to `index.php`.

### .htaccess

```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [QSA,L]
```

Enable mod_rewrite:
```bash
sudo a2enmod rewrite
```

---

## 🔐 Authentication

Use the `/auth/token` endpoint to obtain a JWT token.

### Login

```bash
curl -X POST http://localhost/auth/token \
  -H "username: admin" \
  -H "password: admin@123"
```

Returns:
```json
{
  "token": "eyJ0eXAiOiJKV1QiLCJh...",
  "expires_in": 3600
}
```

---

## 🔁 Authenticated REST Calls

Add `Authorization: Bearer <token>` to headers.

### GET `/product/get`

```bash
curl -X GET http://localhost/product/get \
  -H "Authorization: Bearer <token>"
```

### POST `/product/post`

```bash
curl -X POST http://localhost/product/post \
  -H "Authorization: Bearer <token>" \
  -H "Content-Type: application/json" \
  -d '{"name": "New Product", "price": 99.99}'
```

### PUT `/product/put`

```bash
curl -X PUT http://localhost/product/put \
  -H "Authorization: Bearer <token>" \
  -H "Content-Type: application/json" \
  -d '{"id": 1, "price": 79.99}'
```

### DELETE `/product/delete`

```bash
curl -X DELETE http://localhost/product/delete \
  -H "Authorization: Bearer <token>"
```

---

## 🔁 Fallback to `default.php`

If a requested endpoint (e.g. `/product/unknown`) does not exist:

- The router will fallback to `/product/default.php`
- If `default.php` is also missing, it returns a `404 Not Found`

---

## ✅ Default Users

```php
// Generate secure password hash - https://tinyfilemanager.github.io/docs/pwd.html
$auth_users = array(
    'admin' => '$2y$10$/K.hjNr84lLNDt8fTXjoI.DBp6PpeyoJ.mGwrrLuCZfAwfSAGqhOW', // admin@123
    'user' => '$2y$10$Fg6Dz8oH9fPoZ2jJan5tZuv6Z4Kp7avtQ9bDfrdRntXtPeiMAZyGO'  // 12345
);
```

To generate new password hashes:  
👉 [Use this password hash tool](https://tinyfilemanager.github.io/docs/pwd.html)

---

## 📦 Installation

```bash
git clone https://github.com/anthonyzee/php-quick-rest.git
cd php-quick-rest
composer install
```

Ensure Apache is configured with `mod_rewrite` and your virtual host points to this project folder.

---

## 💡 Tips and Suggestions

- Use `default.php` to handle generic or fallback logic in a module. For example, in the `/product` folder, you can use `default.php` to return a singleton product query by inspecting `$_GET` or `$_REQUEST`.

- Add `require_once __DIR__ . '/../vendor/autoload.php';` at the top of your scripts to load Composer dependencies (e.g., JWT classes) when using Composer.

- Make sure your `.htaccess` is present in every REST module folder to ensure Apache correctly routes to `index.php`.

- For new users, create hashed passwords using: https://tinyfilemanager.github.io/docs/pwd.html and store them in `$auth_users`.

- Secure your folders and APIs in production by disabling directory listing and avoiding exposing sensitive files (e.g., `.env`, `*.log`).

## 📦 Installing via Composer (from GitHub)

To install this project directly from GitHub using Composer:

1. Create a `composer.json` file in the root folder of your project and add the following content:

```json
{
  "require": {
    "anthonyzee/php-quick-rest": "dev-main"
  },
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/anthonyzee/php-quick-rest"
    }
  ],
  "minimum-stability": "dev",
  "prefer-stable": true
}
```

2. Run the following command to fetch the project and its dependencies:

```bash
composer update
```

3. After installation, make sure to include the autoloader in your PHP scripts:

```php
require_once __DIR__ . '/vendor/autoload.php';
```

## 📄 License

MIT License – use and modify freely.
