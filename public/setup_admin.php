<?php
require_once '../config/config.php';
require_once '../app/core/Database.php';

try {
    $db = Database::getInstance();
    $stmt = $db->query("UPDATE users SET role = 'admin' WHERE id = 1");
    echo "<h1>Setup Complete</h1>";
    echo "<p>User ID 1 has been promoted to Admin.</p>";
    echo "<p>Please delete this file for security.</p>";
    echo "<a href='../public/auth/login'>Go to Login</a>";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
