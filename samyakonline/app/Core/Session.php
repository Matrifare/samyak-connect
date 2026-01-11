<?php
/**
 * Secure Session Management Class
 * Handles sessions, CSRF protection, and flash messages
 */

namespace App\Core;

class Session
{
    private static ?Session $instance = null;
    private bool $started = false;

    private function __construct()
    {
        $this->start();
    }

    /**
     * Get singleton instance
     */
    public static function getInstance(): Session
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Start session with secure settings
     */
    private function start(): void
    {
        if ($this->started) {
            return;
        }

        // Secure session configuration
        ini_set('session.use_strict_mode', '1');
        ini_set('session.use_only_cookies', '1');
        ini_set('session.cookie_httponly', '1');
        ini_set('session.cookie_samesite', 'Lax');
        
        // Use secure cookies in production
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            ini_set('session.cookie_secure', '1');
        }

        // Set session name
        session_name('SAMYAK_SESSION');

        // Start session
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->started = true;

        // Regenerate session ID periodically
        $this->regenerateIfNeeded();

        // Initialize CSRF token if not exists
        if (!isset($_SESSION['csrf_token'])) {
            $this->regenerateCsrfToken();
        }
    }

    /**
     * Regenerate session ID if needed (every 30 minutes)
     */
    private function regenerateIfNeeded(): void
    {
        $regenerateInterval = 1800; // 30 minutes

        if (!isset($_SESSION['last_regeneration'])) {
            $_SESSION['last_regeneration'] = time();
            return;
        }

        if (time() - $_SESSION['last_regeneration'] > $regenerateInterval) {
            $this->regenerate();
        }
    }

    /**
     * Regenerate session ID
     */
    public function regenerate(): void
    {
        session_regenerate_id(true);
        $_SESSION['last_regeneration'] = time();
    }

    /**
     * Set session value
     */
    public function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Get session value
     */
    public function get(string $key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Check if session key exists
     */
    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Remove session value
     */
    public function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    /**
     * Clear all session data
     */
    public function clear(): void
    {
        $_SESSION = [];
    }

    /**
     * Destroy session
     */
    public function destroy(): void
    {
        $this->clear();
        
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        session_destroy();
        $this->started = false;
    }

    /**
     * Set flash message
     */
    public function setFlash(string $key, $value): void
    {
        $_SESSION['_flash'][$key] = $value;
    }

    /**
     * Get flash message (automatically removed after reading)
     */
    public function getFlash(string $key, $default = null)
    {
        $value = $_SESSION['_flash'][$key] ?? $default;
        unset($_SESSION['_flash'][$key]);
        return $value;
    }

    /**
     * Check if flash message exists
     */
    public function hasFlash(string $key): bool
    {
        return isset($_SESSION['_flash'][$key]);
    }

    /**
     * Get CSRF token
     */
    public function getCsrfToken(): string
    {
        return $_SESSION['csrf_token'] ?? '';
    }

    /**
     * Regenerate CSRF token
     */
    public function regenerateCsrfToken(): string
    {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        return $_SESSION['csrf_token'];
    }

    /**
     * Validate CSRF token
     */
    public function validateCsrfToken(string $token): bool
    {
        if (empty($token) || empty($_SESSION['csrf_token'])) {
            return false;
        }
        return hash_equals($_SESSION['csrf_token'], $token);
    }

    /**
     * Get user ID from session
     */
    public function getUserId(): ?string
    {
        return $_SESSION['user']['matri_id'] ?? null;
    }

    /**
     * Check if user is logged in
     */
    public function isLoggedIn(): bool
    {
        return isset($_SESSION['user']) && !empty($_SESSION['user']['matri_id']);
    }
}
