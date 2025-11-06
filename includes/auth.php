<?php
/**
 * Authentication helper functions
 */

require_once __DIR__ . '/db.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Check if user is logged in (customer)
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['user_email']);
}

/**
 * Check if admin is logged in
 */
function isAdminLoggedIn() {
    return isset($_SESSION['admin_id']) && isset($_SESSION['admin_email']);
}

/**
 * Require user to be logged in, redirect if not
 */
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: /login.php');
        exit;
    }
}

/**
 * Require admin to be logged in, redirect if not
 */
function requireAdminLogin() {
    if (!isAdminLoggedIn()) {
        header('Location: /admin/login.php');
        exit;
    }
}

/**
 * Get current user ID
 */
function getCurrentUserId() {
    return $_SESSION['user_id'] ?? null;
}

/**
 * Get current admin ID
 */
function getCurrentAdminId() {
    return $_SESSION['admin_id'] ?? null;
}

/**
 * Login user
 */
function loginUser($userId, $userEmail, $userName) {
    $_SESSION['user_id'] = $userId;
    $_SESSION['user_email'] = $userEmail;
    $_SESSION['user_name'] = $userName;
}

/**
 * Login admin
 */
function loginAdmin($adminId, $adminEmail, $adminName) {
    $_SESSION['admin_id'] = $adminId;
    $_SESSION['admin_email'] = $adminEmail;
    $_SESSION['admin_name'] = $adminName;
}

/**
 * Logout user
 */
function logoutUser() {
    unset($_SESSION['user_id']);
    unset($_SESSION['user_email']);
    unset($_SESSION['user_name']);
}

/**
 * Logout admin
 */
function logoutAdmin() {
    unset($_SESSION['admin_id']);
    unset($_SESSION['admin_email']);
    unset($_SESSION['admin_name']);
}

/**
 * Generate CSRF token
 */
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verify CSRF token
 */
function verifyCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

