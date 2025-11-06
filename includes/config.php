<?php
/**
 * Configuration file for SparklePro Cleaning Services
 * 
 * IMPORTANT: Update these values with your Hostinger database credentials
 * This file should NOT be committed to version control in production
 */

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'your_database_name');  // Change this
define('DB_USER', 'your_database_user');  // Change this
define('DB_PASS', 'your_database_password');  // Change this
define('DB_CHARSET', 'utf8mb4');

// Site configuration
define('SITE_NAME', 'SparklePro Cleaning Services');
define('SITE_URL', 'https://yourdomain.com');  // Change this to your actual domain

// Paths
define('BASE_PATH', dirname(__DIR__));
define('PUBLIC_PATH', BASE_PATH . '/public');
define('INCLUDES_PATH', BASE_PATH . '/includes');
define('UPLOADS_PATH', BASE_PATH . '/assets/uploads/cv');
define('UPLOADS_URL', '/assets/uploads/cv');

// File upload settings
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_CV_TYPES', ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document']);

// Employee workload baseline (hours per week for full-time)
define('BASELINE_HOURS_PER_WEEK', 40);

// Session configuration
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0); // Set to 1 if using HTTPS

// Timezone
date_default_timezone_set('UTC');

// Error reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1); // Set to 0 in production

