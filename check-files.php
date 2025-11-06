<?php
/**
 * File Location Checker
 * This script helps you verify where your files are located
 * Access: https://rosybrown-barracuda-297414.hostingersite.com/check-files.php
 */

$root = __DIR__;
$requiredFiles = [
    'index.php' => 'Home page',
    'login.php' => 'Login page',
    'register.php' => 'Registration page',
    'services.php' => 'Services page',
    'account.php' => 'Account page',
    'request-quote.php' => 'Quote request page',
    'join-our-team.php' => 'CV upload page',
    'admin/login.php' => 'Admin login',
    'includes/config.php' => 'Configuration file',
    'includes/db.php' => 'Database connection',
    'models/User.php' => 'User model',
];

echo "<h1>File Location Checker</h1>";
echo "<p><strong>Root Directory:</strong> " . htmlspecialchars($root) . "</p>";
echo "<hr>";

echo "<h2>Required Files Status</h2>";
echo "<table border='1' cellpadding='10' style='border-collapse: collapse; width: 100%;'>";
echo "<tr><th>File</th><th>Description</th><th>Status</th><th>Location</th></tr>";

$allFound = true;
foreach ($requiredFiles as $file => $description) {
    $fullPath = $root . '/' . $file;
    $exists = file_exists($fullPath);
    $status = $exists ? '✅ Found' : '❌ Missing';
    $location = $exists ? htmlspecialchars($fullPath) : 'Not found';
    
    if (!$exists) {
        $allFound = false;
    }
    
    echo "<tr>";
    echo "<td><code>" . htmlspecialchars($file) . "</code></td>";
    echo "<td>" . htmlspecialchars($description) . "</td>";
    echo "<td><strong>" . $status . "</strong></td>";
    echo "<td>" . $location . "</td>";
    echo "</tr>";
}

echo "</table>";

echo "<hr>";
echo "<h2>File Structure Check</h2>";

// Check if files are in wrong location (public subdirectory)
$publicDir = $root . '/public';
if (is_dir($publicDir)) {
    echo "<p style='color: orange;'><strong>⚠️ WARNING:</strong> Found a <code>/public/</code> directory!</p>";
    echo "<p>If your PHP files are in <code>/public/</code>, they need to be moved to the root.</p>";
    
    $filesInPublic = [];
    if ($handle = opendir($publicDir)) {
        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != ".." && pathinfo($entry, PATHINFO_EXTENSION) == 'php') {
                $filesInPublic[] = $entry;
            }
        }
        closedir($handle);
    }
    
    if (!empty($filesInPublic)) {
        echo "<p><strong>PHP files found in /public/ directory:</strong></p>";
        echo "<ul>";
        foreach ($filesInPublic as $file) {
            echo "<li><code>" . htmlspecialchars($file) . "</code> - <strong>Move this to root!</strong></li>";
        }
        echo "</ul>";
    }
}

if ($allFound) {
    echo "<p style='color: green;'><strong>✅ All required files are in the correct location!</strong></p>";
} else {
    echo "<p style='color: red;'><strong>❌ Some files are missing. Please check the table above.</strong></p>";
}

echo "<hr>";
echo "<h2>Quick Fix Instructions</h2>";
echo "<ol>";
echo "<li>All PHP files (login.php, register.php, etc.) must be in <code>public_html/</code> root</li>";
echo "<li>Move files from <code>public_html/public/</code> to <code>public_html/</code> if they're in a subdirectory</li>";
echo "<li>Keep folders: <code>includes/</code>, <code>models/</code>, <code>assets/</code>, <code>admin/</code></li>";
echo "<li>After moving, refresh this page to verify</li>";
echo "</ol>";

echo "<hr>";
echo "<p><small>Delete this file after fixing the structure.</small></p>";
?>

