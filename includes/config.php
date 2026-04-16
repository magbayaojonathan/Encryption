<?php
// Enable error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// OFFLINE MODE - Set to true to run without database
define('OFFLINE_MODE', false);

// Database credentials
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'real_estate_db');

// Base URL
define('BASE_URL', 'http://localhost/Encryption/');

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Redirect to login if not logged in
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: ' . BASE_URL . 'login.php');
        exit;
    }
}

// Redirect if already logged in
function redirectIfLoggedIn() {
    if (isLoggedIn()) {
        header('Location: ' . BASE_URL . 'dashboard.php');
        exit;
    }
}

// Get current user
function getCurrentUser() {
    return isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
}

// Logout
function logout() {
    session_destroy();
    header('Location: ' . BASE_URL . 'login.php');
    exit;
}
?>
