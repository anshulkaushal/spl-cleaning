<?php
/**
 * Configuration file for SparklePro Cleaning Services
 * 
 * IMPORTANT: Update these values with your Hostinger database credentials
 * This file should NOT be committed to version control in production
 */

// Database configuration
define('DB_HOST', '127.0.0.1');
define('DB_PORT', '3306');
define('DB_NAME', 'u182465577_cleaning');
define('DB_USER', 'u182465577_cleaning');
define('DB_PASS', 'Cleaning123#@!');
define('DB_CHARSET', 'utf8mb4');

// Site configuration
define('SITE_NAME', 'SparklePro Cleaning Services');
define('SITE_URL', 'https://rosybrown-barracuda-297414.hostingersite.com');  // Change this to your actual domain

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

