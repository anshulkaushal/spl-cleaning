<?php
/**
 * Simple PHP Test File
 * Access this file to verify PHP is working on your server
 * Delete this file after testing
 */

echo "<h1>PHP is Working!</h1>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>Server: " . $_SERVER['SERVER_SOFTWARE'] . "</p>";
echo "<p>Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
echo "<p>Current File: " . __FILE__ . "</p>";

// Test database connection
echo "<h2>Database Connection Test</h2>";
require_once __DIR__ . '/../includes/config.php';
echo "<p>DB Host: " . DB_HOST . "</p>";
echo "<p>DB Port: " . DB_PORT . "</p>";
echo "<p>DB Name: " . DB_NAME . "</p>";

try {
    require_once __DIR__ . '/../includes/db.php';
    $db = getDB();
    echo "<p style='color: green;'>✓ Database connection successful!</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Database connection failed: " . htmlspecialchars($e->getMessage()) . "</p>";
}

phpinfo();
?>

