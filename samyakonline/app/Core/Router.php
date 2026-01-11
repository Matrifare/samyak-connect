<?php
/**
 * Simple MVC Router
 * Maps URLs to controllers and actions
 */

namespace App\Core;

class Router
{
    private array $routes = [];
    private array $params = [];

    /**
     * Add a route
     */
    public function add(string $route, array $params = []): void
    {
        // Convert route to regex
        $route = preg_replace('/\//', '\\/', $route);
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z0-9-]+)', $route);
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);
        $route = '/^' . $route . '$/i';

        $this->routes[$route] = $params;
    }

    /**
     * Match URL to route
     */
    public function match(string $url): bool
    {
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $params[$key] = $match;
                    }
                }
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    /**
     * Dispatch the route
     */
    public function dispatch(string $url): void
    {
        $url = $this->removeQueryString($url);
        $url = trim($url, '/');

        if ($this->match($url)) {
            $controller = $this->params['controller'] ?? '';
            $controller = $this->convertToStudlyCaps($controller);
            $controller = "App\\Controllers\\{$controller}Controller";

            if (class_exists($controller)) {
                $controllerObject = new $controller($this->params);

                $action = $this->params['action'] ?? 'index';
                $action = $this->convertToCamelCase($action);

                if (is_callable([$controllerObject, $action])) {
                    $controllerObject->$action();
                } else {
                    throw new \RuntimeException("Method $action not found in controller $controller");
                }
            } else {
                throw new \RuntimeException("Controller $controller not found");
            }
        } else {
            throw new \RuntimeException("Route not found: $url", 404);
        }
    }

    /**
     * Convert string to StudlyCaps
     */
    private function convertToStudlyCaps(string $string): string
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    /**
     * Convert string to camelCase
     */
    private function convertToCamelCase(string $string): string
    {
        return lcfirst($this->convertToStudlyCaps($string));
    }

    /**
     * Remove query string from URL
     */
    private function removeQueryString(string $url): string
    {
        if ($url !== '') {
            $parts = explode('?', $url, 2);
            if (strpos($parts[0], '=') === false) {
                $url = $parts[0];
            } else {
                $url = '';
            }
        }
        return $url;
    }

    /**
     * Get route parameters
     */
    public function getParams(): array
    {
        return $this->params;
    }
}
