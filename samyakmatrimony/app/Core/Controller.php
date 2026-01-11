<?php
/**
 * Base Controller Class
 * Provides common functionality for all controllers
 */

namespace App\Core;

abstract class Controller
{
    protected Database $db;
    protected Session $session;
    protected array $params;
    protected ?array $user;
    protected array $appConfig;

    public function __construct(array $params = [])
    {
        $this->params = $params;
        $this->db = Database::getInstance();
        $this->session = Session::getInstance();
        $this->user = $this->session->getUser();
        $this->appConfig = require __DIR__ . '/../../config/app.php';
    }

    /**
     * Render a view template
     */
    protected function render(string $view, array $data = []): void
    {
        // Add common data
        $data['user'] = $this->user;
        $data['csrf_token'] = $this->session->getCsrfToken();
        $data['app'] = $this->appConfig;
        $data['flash'] = [
            'success' => $this->session->getFlash('success'),
            'error' => $this->session->getFlash('error'),
            'info' => $this->session->getFlash('info')
        ];

        // Extract data for views
        extract($data);

        // Build view path
        $viewFile = __DIR__ . "/../../templates/{$view}.php";
        
        if (file_exists($viewFile)) {
            ob_start();
            include $viewFile;
            $content = ob_get_clean();
            
            // Include layout if not API
            if (!($data['no_layout'] ?? false)) {
                include __DIR__ . '/../../templates/layouts/main.php';
            } else {
                echo $content;
            }
        } else {
            throw new \Exception("View {$view} not found", 500);
        }
    }

    /**
     * Redirect to URL
     */
    protected function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }

    /**
     * Return JSON response
     */
    protected function json(array $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * Check if user is authenticated
     */
    protected function isAuthenticated(): bool
    {
        return $this->session->isAuthenticated();
    }

    /**
     * Require authentication or redirect to login
     */
    protected function requireAuth(): void
    {
        if (!$this->isAuthenticated()) {
            $this->session->set('redirect_after_login', $_SERVER['REQUEST_URI']);
            $this->session->setFlash('error', 'Please login to continue');
            $this->redirect('/login');
        }
    }

    /**
     * Require CSRF token validation
     */
    protected function requireCsrf(): void
    {
        $token = $this->getPost('csrf_token') ?: ($_SERVER['HTTP_X_CSRF_TOKEN'] ?? '');
        if (!$this->session->verifyCsrfToken($token)) {
            $this->session->setFlash('error', 'Invalid security token. Please try again.');
            $this->redirect($_SERVER['HTTP_REFERER'] ?? '/');
        }
    }

    /**
     * Get POST parameter
     */
    protected function getPost(string $key, $default = null)
    {
        return $_POST[$key] ?? $default;
    }

    /**
     * Get GET parameter
     */
    protected function getQuery(string $key, $default = null)
    {
        return $_GET[$key] ?? $default;
    }

    /**
     * Set flash message
     */
    protected function flash(string $key, string $message): void
    {
        $this->session->setFlash($key, $message);
    }

    /**
     * Check if request is AJAX
     */
    protected function isAjax(): bool
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    /**
     * Escape HTML for output
     */
    protected function e(?string $value): string
    {
        return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
    }
}
