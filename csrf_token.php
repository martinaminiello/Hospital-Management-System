<?php


/**
 * CSRF Token Protection Helper
 * 
 * This file provides functions to generate, store, and validate CSRF tokens
 * to protect against Cross-Site Request Forgery attacks.
 */

/**
 * Initialize CSRF token for session
 * Call this function after session_start()
 */
function initializeCSRFToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
}

/**
 * Get the current CSRF token
 * 
 * @return string The CSRF token for the current session
 */
function getCSRFToken() {
    if (empty($_SESSION['csrf_token'])) {
        initializeCSRFToken();
    }
    return $_SESSION['csrf_token'];
}

/**
 * Generate HTML for hidden CSRF token field
 * Use this in forms to include the CSRF token
 * 
 * @return string HTML hidden input field with CSRF token
 */
function getCSRFTokenField() {
    $token = getCSRFToken();
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '" />';
}

/**
 * Validate CSRF token from POST request
 * Call this before processing any form submission
 * 
 * @return bool True if token is valid, false otherwise
 */
function validateCSRFToken() {
    // Check if token exists in session
    if (empty($_SESSION['csrf_token'])) {
        return false;
    }
    
    // Check if token is provided in the request
    if (empty($_POST['csrf_token'])) {
        return false;
    }
    
    // Compare tokens using hash_equals to prevent timing attacks
    return hash_equals($_SESSION['csrf_token'], $_POST['csrf_token']);
}

/**
 * Validate CSRF token and die with error if invalid
 * Use this for critical operations
 */
function requireValidCSRFToken() {
    if (!validateCSRFToken()) {
        http_response_code(403);
        die('CSRF token validation failed. Request rejected.');
    }
}

/**
 * Regenerate CSRF token after login
 * Call this to prevent fixation attacks
 */
function regenerateCSRFToken() {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf_token'];
}
?>
