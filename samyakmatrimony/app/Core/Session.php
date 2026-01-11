<?php
/**
 * Session Management Class - Singleton
 * Handles secure session management with CSRF protection
 */

namespace App\Core;

class Session
{
    private static ?Session $instance = null;
    private array $config;

    private function __construct()
    {
        $this->config = require __DIR__ . '/../../config/app.php';
        $this->start();
    }

    public static function getInstance(): Session
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            $sessionConfig = $this->config['session'] ?? [];
            
            session_name($sessionConfig['name'] ?? 'samyak_session');
            
            session_set_cookie_params([
                'lifetime' => $sessionConfig['lifetime'] ?? 7200,
                'path' => '/',
                'domain' => '',
                'secure' => isset($_SERVER['HTTPS']),
                'httponly' => true,
                'samesite' => 'Lax'
            ]);

            session_start();

            // Check idle timeout
            $this->checkIdleTimeout($sessionConfig['idle_timeout'] ?? 1800);

            // Generate CSRF token if not exists
            if (!isset($_SESSION['csrf_token'])) {
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            }

            // Update last activity
            $_SESSION['last_activity'] = time();
        }
    }

    private function checkIdleTimeout(int $timeout): void
    {
        if (isset($_SESSION['last_activity']) && 
            (time() - $_SESSION['last_activity']) > $timeout) {
            $this->destroy();
            session_start();
        }
    }

    public function get(string $key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    public function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public function getFlash(string $key, $default = null)
    {
        $value = $_SESSION['flash'][$key] ?? $default;
        unset($_SESSION['flash'][$key]);
        return $value;
    }

    public function setFlash(string $key, $value): void
    {
        $_SESSION['flash'][$key] = $value;
    }

    public function getCsrfToken(): string
    {
        return $_SESSION['csrf_token'] ?? '';
    }

    public function verifyCsrfToken(string $token): bool
    {
        return hash_equals($_SESSION['csrf_token'] ?? '', $token);
    }

    public function regenerate(): void
    {
        session_regenerate_id(true);
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    public function destroy(): void
    {
        $_SESSION = [];

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
    }

    public function isAuthenticated(): bool
    {
        return isset($_SESSION['user']['matri_id']);
    }

    public function getUser(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    private function __clone() {}
    public function __wakeup()
    {
        throw new \RuntimeException("Cannot unserialize singleton");
    }
}
