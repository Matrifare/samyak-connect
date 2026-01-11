<?php
/**
 * Authentication Guard
 * Securely validates user session with additional checks
 */

// Include security helper if available
if (file_exists(__DIR__ . '/lib/Security.php')) {
    include_once __DIR__ . '/lib/Security.php';
}

/**
 * Check if user is authenticated
 */
function isAuthenticated(): bool {
    // Check for admin session
    if (!empty($_SESSION['admin_user_name'])) {
        return true;
    }
    
    // Check for regular user session
    if (empty($_SESSION['user_name']) || empty($_SESSION['user_id'])) {
        return false;
    }
    
    // Validate user_id format (should be alphanumeric)
    if (!preg_match('/^[a-zA-Z0-9_-]+$/', trim($_SESSION['user_id']))) {
        return false;
    }
    
    // Check session timeout (optional - 12 hour absolute timeout)
    if (isset($_SESSION['session_start_time'])) {
        $maxSessionTime = 12 * 60 * 60; // 12 hours
        if (time() - $_SESSION['session_start_time'] > $maxSessionTime) {
            // Session expired - clear it
            session_unset();
            session_destroy();
            return false;
        }
    }
    
    // Check idle timeout (optional - 30 minute idle timeout)
    if (isset($_SESSION['last_activity'])) {
        $maxIdleTime = 30 * 60; // 30 minutes
        if (time() - $_SESSION['last_activity'] > $maxIdleTime) {
            // Idle timeout - clear session
            session_unset();
            session_destroy();
            return false;
        }
    }
    
    // Update last activity time
    $_SESSION['last_activity'] = time();
    
    return true;
}

/**
 * Require authentication or redirect to login
 */
function requireAuth(string $redirectUrl = 'index'): void {
    if (!isAuthenticated()) {
        header('Location: ' . $redirectUrl);
        exit;
    }
}

// Perform authentication check
if (!isAuthenticated()) {
    header('Location: index');
    exit;
}
