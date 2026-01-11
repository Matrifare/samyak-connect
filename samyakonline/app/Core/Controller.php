<?php
/**
 * Base Controller Class
 * All controllers extend this class
 */

namespace App\Core;

abstract class Controller
{
    protected array $params = [];
    protected Database $db;
    protected Session $session;
    protected ?array $user = null;

    public function __construct(array $params = [])
    {
        $this->params = $params;
        $this->db = Database::getInstance();
        $this->session = Session::getInstance();
        $this->user = $this->session->get('user');
    }

    /**
     * Render a view template
     */
    protected function render(string $view, array $data = []): void
    {
        // Extract data to variables
        extract($data);
        
        // Add common data
        $user = $this->user;
        $config = $this->getConfig();
        $csrfToken = $this->session->getCsrfToken();

        // Build view path - check both templates and views folders
        $viewFile = __DIR__ . "/../../templates/pages/{$view}.php";
        $altViewFile = __DIR__ . "/../../templates/{$view}.php";
        
        if (!file_exists($viewFile)) {
            $viewFile = $altViewFile;
        }

        if (file_exists($viewFile)) {
            // Include the view file directly (it includes its own header/footer)
            require $viewFile;
        } else {
            throw new \RuntimeException("View not found: {$view}");
        }
    }

    /**
     * Render JSON response
     */
    protected function json(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * Redirect to another URL
     */
    protected function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }

    /**
     * Check if user is authenticated
     */
    protected function isAuthenticated(): bool
    {
        return $this->user !== null;
    }

    /**
     * Require authentication
     */
    protected function requireAuth(): void
    {
        if (!$this->isAuthenticated()) {
            $this->session->setFlash('error', 'Please login to continue.');
            $this->redirect('/login');
        }
    }

    /**
     * Get POST data with sanitization
     */
    protected function getPost(string $key, $default = null)
    {
        return isset($_POST[$key]) ? $this->sanitize($_POST[$key]) : $default;
    }

    /**
     * Get GET data with sanitization
     */
    protected function getQuery(string $key, $default = null)
    {
        return isset($_GET[$key]) ? $this->sanitize($_GET[$key]) : $default;
    }

    /**
     * Sanitize input
     */
    protected function sanitize($value)
    {
        if (is_array($value)) {
            return array_map([$this, 'sanitize'], $value);
        }
        return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Validate CSRF token
     */
    protected function validateCsrf(): bool
    {
        $token = $this->getPost('csrf_token') ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
        return $this->session->validateCsrfToken($token);
    }

    /**
     * Require valid CSRF token
     */
    protected function requireCsrf(): void
    {
        if (!$this->validateCsrf()) {
            $this->json(['error' => 'Invalid security token. Please refresh and try again.'], 403);
        }
    }

    /**
     * Get site configuration
     */
    protected function getConfig(): array
    {
        static $config = null;
        
        if ($config === null) {
            $result = $this->db->selectOne("SELECT * FROM site_config WHERE id = ?", [1]);
            $config = $result ?: [];
        }
        
        return $config;
    }

    /**
     * Set flash message
     */
    protected function flash(string $type, string $message): void
    {
        $this->session->setFlash($type, $message);
    }

    /**
     * Get validation errors
     */
    protected function getErrors(): array
    {
        return $this->session->getFlash('errors') ?? [];
    }
}
