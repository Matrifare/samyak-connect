<?php
/**
 * Security Helper Class
 * Provides security utilities for XSS prevention, sanitization, etc.
 */

namespace App\Core;

class Security
{
    /**
     * Escape HTML for safe output
     */
    public static function escape(?string $value): string
    {
        return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    /**
     * Alias for escape
     */
    public static function e(?string $value): string
    {
        return self::escape($value);
    }

    /**
     * Sanitize string (remove tags, trim)
     */
    public static function sanitize(?string $value): string
    {
        if ($value === null) {
            return '';
        }
        return trim(strip_tags($value));
    }

    /**
     * Sanitize email
     */
    public static function sanitizeEmail(?string $email): string
    {
        return filter_var($email ?? '', FILTER_SANITIZE_EMAIL);
    }

    /**
     * Generate CSRF field HTML
     */
    public static function csrfField(): string
    {
        $token = Session::getInstance()->getCsrfToken();
        return '<input type="hidden" name="csrf_token" value="' . self::escape($token) . '">';
    }

    /**
     * Hash password securely
     */
    public static function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_ARGON2ID);
    }

    /**
     * Verify password
     */
    public static function verifyPassword(string $password, string $hash): bool
    {
        // Handle legacy MD5 passwords
        if (strlen($hash) === 32 && ctype_xdigit($hash)) {
            return md5($password) === $hash;
        }
        return password_verify($password, $hash);
    }

    /**
     * Generate random token
     */
    public static function generateToken(int $length = 32): string
    {
        return bin2hex(random_bytes($length));
    }

    /**
     * Validate file upload
     */
    public static function validateUpload(array $file, array $allowedTypes = [], int $maxSize = 5242880): array
    {
        $errors = [];

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $errors[] = 'File upload failed';
            return $errors;
        }

        if ($file['size'] > $maxSize) {
            $errors[] = 'File is too large. Maximum size is ' . ($maxSize / 1024 / 1024) . 'MB';
        }

        if (!empty($allowedTypes)) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $file['tmp_name']);
            finfo_close($finfo);

            if (!in_array($mimeType, $allowedTypes)) {
                $errors[] = 'Invalid file type';
            }
        }

        return $errors;
    }
}

/**
 * Global escape function for templates
 */
function e(?string $value): string
{
    return Security::e($value);
}
