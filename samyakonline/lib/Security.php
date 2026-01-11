<?php
/**
 * Security Helper Class
 * Provides secure input validation, sanitization, and CSRF protection
 */

class Security
{
    /**
     * Generate CSRF token and store in session
     */
    public static function generateCsrfToken(): string
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            $_SESSION['csrf_token_time'] = time();
        }
        return $_SESSION['csrf_token'];
    }
    
    /**
     * Validate CSRF token from request
     */
    public static function validateCsrfToken(?string $token): bool
    {
        if (empty($token) || empty($_SESSION['csrf_token'])) {
            return false;
        }
        
        // Token expires after 2 hours
        if (time() - ($_SESSION['csrf_token_time'] ?? 0) > 7200) {
            unset($_SESSION['csrf_token'], $_SESSION['csrf_token_time']);
            return false;
        }
        
        return hash_equals($_SESSION['csrf_token'], $token);
    }
    
    /**
     * Get CSRF hidden input field
     */
    public static function csrfField(): string
    {
        $token = self::generateCsrfToken();
        return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
    }
    
    /**
     * Sanitize string for safe output (XSS prevention)
     */
    public static function escape(mixed $value): string
    {
        if ($value === null) {
            return '';
        }
        return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Alias for escape - for output encoding
     */
    public static function e(mixed $value): string
    {
        return self::escape($value);
    }
    
    /**
     * Sanitize integer
     */
    public static function sanitizeInt(mixed $value): int
    {
        return (int) filter_var($value, FILTER_SANITIZE_NUMBER_INT);
    }
    
    /**
     * Sanitize float
     */
    public static function sanitizeFloat(mixed $value): float
    {
        return (float) filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }
    
    /**
     * Sanitize email
     */
    public static function sanitizeEmail(mixed $value): string
    {
        return filter_var(trim((string)$value), FILTER_SANITIZE_EMAIL) ?: '';
    }
    
    /**
     * Validate email format
     */
    public static function isValidEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
    
    /**
     * Sanitize phone number (digits only)
     */
    public static function sanitizePhone(mixed $value): string
    {
        return preg_replace('/[^0-9+]/', '', (string)$value);
    }
    
    /**
     * Sanitize alphanumeric string
     */
    public static function sanitizeAlphanumeric(mixed $value): string
    {
        return preg_replace('/[^a-zA-Z0-9]/', '', (string)$value);
    }
    
    /**
     * Sanitize profile/matri ID (alphanumeric with limited special chars)
     */
    public static function sanitizeProfileId(mixed $value): string
    {
        return preg_replace('/[^a-zA-Z0-9_-]/', '', (string)$value);
    }
    
    /**
     * Validate and sanitize array of integers for IN clause
     */
    public static function sanitizeIntArray(mixed $value): string
    {
        if (empty($value)) {
            return '';
        }
        
        if (is_string($value)) {
            $value = explode(',', $value);
        }
        
        if (!is_array($value)) {
            return '';
        }
        
        $cleaned = array_map('intval', array_filter($value, 'is_numeric'));
        return implode(',', $cleaned);
    }
    
    /**
     * Validate and sanitize array of strings for IN clause (with quotes)
     */
    public static function sanitizeStringArray(mixed $value, $connection): string
    {
        if (empty($value)) {
            return '';
        }
        
        if (is_string($value)) {
            $value = explode(',', $value);
        }
        
        if (!is_array($value)) {
            return '';
        }
        
        $cleaned = array_map(function($item) use ($connection) {
            return "'" . mysqli_real_escape_string($connection, trim((string)$item)) . "'";
        }, $value);
        
        return implode(',', $cleaned);
    }
    
    /**
     * Validate allowed values (whitelist)
     */
    public static function validateAllowed(mixed $value, array $allowed, $default = null): mixed
    {
        if (in_array($value, $allowed, true)) {
            return $value;
        }
        return $default;
    }
    
    /**
     * Safe session check for authentication
     */
    public static function isAuthenticated(): bool
    {
        return !empty($_SESSION['user_name']) && !empty($_SESSION['user_id']);
    }
    
    /**
     * Safe session check for admin
     */
    public static function isAdmin(): bool
    {
        return !empty($_SESSION['admin_user_name']);
    }
    
    /**
     * Require authentication or redirect
     */
    public static function requireAuth(string $redirectUrl = 'login'): void
    {
        if (!self::isAuthenticated() && !self::isAdmin()) {
            header('Location: ' . $redirectUrl);
            exit;
        }
    }
    
    /**
     * Regenerate session ID (call after login/privilege change)
     */
    public static function regenerateSession(): void
    {
        session_regenerate_id(true);
    }
    
    /**
     * Validate file upload is an image
     */
    public static function validateImageUpload(array $file, int $maxSize = 5242880): array
    {
        $errors = [];
        
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $errors[] = 'File upload failed';
            return $errors;
        }
        
        // Check file size (default 5MB)
        if ($file['size'] > $maxSize) {
            $errors[] = 'File too large. Maximum size is ' . ($maxSize / 1048576) . 'MB';
        }
        
        // Validate MIME type via actual file content
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file['tmp_name']);
        
        $allowedMimes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($mimeType, $allowedMimes)) {
            $errors[] = 'Invalid file type. Only JPG, PNG, and GIF are allowed';
        }
        
        // Verify it's actually an image using getimagesize
        $imageInfo = @getimagesize($file['tmp_name']);
        if ($imageInfo === false) {
            $errors[] = 'File is not a valid image';
        }
        
        return $errors;
    }
    
    /**
     * Generate safe filename for uploads
     */
    public static function generateSafeFilename(string $originalName): string
    {
        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        
        if (!in_array($extension, $allowedExtensions)) {
            $extension = 'jpg';
        }
        
        return bin2hex(random_bytes(16)) . '.' . $extension;
    }
    
    /**
     * Build safe WHERE clause conditions (preventing SQL injection)
     * Returns array with SQL fragment and parameters for prepared statement
     */
    public static function buildSearchCondition(
        string $field, 
        mixed $value, 
        string $operator = '=',
        $connection = null
    ): array {
        if (empty($value)) {
            return ['sql' => '', 'params' => []];
        }
        
        $field = preg_replace('/[^a-zA-Z0-9_.]/', '', $field);
        
        switch ($operator) {
            case 'IN':
                if (is_array($value)) {
                    $placeholders = implode(',', array_fill(0, count($value), '?'));
                    return [
                        'sql' => "AND $field IN ($placeholders)",
                        'params' => array_values($value)
                    ];
                }
                break;
            case 'LIKE':
                return [
                    'sql' => "AND $field LIKE ?",
                    'params' => ['%' . $value . '%']
                ];
            case 'BETWEEN':
                if (is_array($value) && count($value) === 2) {
                    return [
                        'sql' => "AND $field BETWEEN ? AND ?",
                        'params' => $value
                    ];
                }
                break;
            default:
                return [
                    'sql' => "AND $field $operator ?",
                    'params' => [$value]
                ];
        }
        
        return ['sql' => '', 'params' => []];
    }
    
    /**
     * Rate limiting check
     */
    public static function checkRateLimit(string $key, int $maxAttempts = 5, int $windowSeconds = 300): bool
    {
        $cacheKey = 'rate_limit_' . md5($key);
        
        if (!isset($_SESSION[$cacheKey])) {
            $_SESSION[$cacheKey] = ['count' => 0, 'first_attempt' => time()];
        }
        
        $data = $_SESSION[$cacheKey];
        
        // Reset if window expired
        if (time() - $data['first_attempt'] > $windowSeconds) {
            $_SESSION[$cacheKey] = ['count' => 1, 'first_attempt' => time()];
            return true;
        }
        
        // Check if limit exceeded
        if ($data['count'] >= $maxAttempts) {
            return false;
        }
        
        // Increment counter
        $_SESSION[$cacheKey]['count']++;
        return true;
    }
}

/**
 * Shorthand function for escaping output
 */
function e($value): string {
    return Security::escape($value);
}
