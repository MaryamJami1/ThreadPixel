<?php
/**
 * ThreadPixel - Application Configuration
 */

// Load .env if it exists
$envFile = dirname(__DIR__) . '/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value);
        }
    }
}

// Application
define('APP_NAME', $_ENV['APP_NAME'] ?? 'ThreadPixel');
define('APP_ENV', $_ENV['APP_ENV'] ?? 'local');
define('APP_URL', $_ENV['APP_URL'] ?? 'http://localhost/threadpixel/public');
define('BASE_URL', APP_URL);

// Database
define('DB_HOST', $_ENV['DB_HOST'] ?? '127.0.0.1');
define('DB_PORT', $_ENV['DB_PORT'] ?? '3306');
define('DB_DATABASE', $_ENV['DB_DATABASE'] ?? 'threadpixel_db');
define('DB_USERNAME', $_ENV['DB_USERNAME'] ?? 'root');
define('DB_PASSWORD', $_ENV['DB_PASSWORD'] ?? '');

// File Uploads - ROOT_PATH is defined in public/index.php
define('UPLOAD_DIR', (defined('ROOT_PATH') ? ROOT_PATH : dirname(__DIR__)) . '/public/assets/uploads/');
define('MAX_FILE_SIZE', 10 * 1024 * 1024); // 10MB

// Allowed file types
define('ALLOWED_IMAGE_TYPES', ['jpg', 'jpeg', 'png', 'gif', 'svg', 'bmp', 'webp']);
define('ALLOWED_ARTWORK_TYPES', ['jpg', 'jpeg', 'png', 'gif', 'svg', 'pdf', 'ai', 'eps', 'psd', 'bmp']);
define('ALLOWED_EMBROIDERY_TYPES', ['dst', 'pes', 'exp', 'jef', 'vp3', 'xxx', 'hus']);

// Security
define('CSRF_SECRET', $_ENV['CSRF_TOKEN_SECRET'] ?? 'ThreadPixel_CSRF_Secret_2024!');
define('SESSION_LIFETIME', $_ENV['SESSION_LIFETIME'] ?? 120);

// Email
define('MAIL_HOST', $_ENV['MAIL_HOST'] ?? 'smtp.mailtrap.io');
define('MAIL_PORT', $_ENV['MAIL_PORT'] ?? 2525);
define('MAIL_USERNAME', $_ENV['MAIL_USERNAME'] ?? '');
define('MAIL_PASSWORD', $_ENV['MAIL_PASSWORD'] ?? '');
define('MAIL_FROM_ADDRESS', $_ENV['MAIL_FROM_ADDRESS'] ?? 'hello@threadpixel.com');
define('MAIL_FROM_NAME', $_ENV['MAIL_FROM_NAME'] ?? APP_NAME);

// Error reporting
if (APP_ENV === 'local') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}
