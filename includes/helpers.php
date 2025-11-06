<?php
/**
 * Helper functions
 */

/**
 * Sanitize input
 */
function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Validate email
 */
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Validate phone number (basic validation)
 */
function isValidPhone($phone) {
    $phone = preg_replace('/[^0-9+()-]/', '', $phone);
    return strlen($phone) >= 10;
}

/**
 * Validate strong password (at least 8 chars, 1 uppercase, 1 lowercase, 1 number)
 */
function isStrongPassword($password) {
    return strlen($password) >= 8 &&
           preg_match('/[A-Z]/', $password) &&
           preg_match('/[a-z]/', $password) &&
           preg_match('/[0-9]/', $password);
}

/**
 * Format date for display
 */
function formatDate($date, $format = 'F j, Y') {
    if (empty($date)) return '';
    $timestamp = is_numeric($date) ? $date : strtotime($date);
    return date($format, $timestamp);
}

/**
 * Format datetime for display
 */
function formatDateTime($datetime, $format = 'F j, Y g:i A') {
    if (empty($datetime)) return '';
    $timestamp = is_numeric($datetime) ? $datetime : strtotime($datetime);
    return date($format, $timestamp);
}

/**
 * Get status badge HTML
 */
function getStatusBadge($status) {
    $badges = [
        'New' => 'badge bg-primary',
        'In Progress' => 'badge bg-warning',
        'Completed' => 'badge bg-success',
        'Cancelled' => 'badge bg-danger',
        'Scheduled' => 'badge bg-info',
        'Shortlisted' => 'badge bg-success',
        'Rejected' => 'badge bg-danger',
        'Hired' => 'badge bg-primary',
    ];
    
    $class = $badges[$status] ?? 'badge bg-secondary';
    return '<span class="' . $class . '">' . htmlspecialchars($status) . '</span>';
}

/**
 * Redirect with message
 */
function redirectWithMessage($url, $message, $type = 'success') {
    $_SESSION['flash_message'] = $message;
    $_SESSION['flash_type'] = $type;
    header('Location: ' . $url);
    exit;
}

/**
 * Get and clear flash message
 */
function getFlashMessage() {
    if (isset($_SESSION['flash_message'])) {
        $message = $_SESSION['flash_message'];
        $type = $_SESSION['flash_type'] ?? 'success';
        unset($_SESSION['flash_message']);
        unset($_SESSION['flash_type']);
        return ['message' => $message, 'type' => $type];
    }
    return null;
}

/**
 * Calculate hours between two times
 */
function calculateHours($startTime, $endTime) {
    $start = new DateTime($startTime);
    $end = new DateTime($endTime);
    $diff = $start->diff($end);
    return $diff->h + ($diff->i / 60);
}

