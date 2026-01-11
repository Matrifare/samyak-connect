<?php
/**
 * Router Class
 * Handles URL routing to controllers
 */

namespace App\Core;

class Router
{
    protected array $routes = [];
    protected array $params = [];

    /**
     * Add a route to the routing table
     */
    public function add(string $route, array $params = []): void
    {
        // Convert route to regex pattern
        $route = preg_replace('/\//', '\\/', $route);
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);
        $route = '/^' . $route . '$/i';

        $this->routes[$route] = $params;
    }

    /**
     * Match URL to a route
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
            $controller = $this->params['controller'];
            $controller = $this->convertToStudlyCaps($controller);
            $controller = "App\\Controllers\\{$controller}Controller";

            if (class_exists($controller)) {
                $controllerObject = new $controller($this->params);

                $action = $this->params['action'];
                $action = $this->convertToCamelCase($action);

                if (method_exists($controllerObject, $action)) {
                    $controllerObject->$action();
                } else {
                    throw new \Exception("Method {$action} not found in {$controller}", 404);
                }
            } else {
                throw new \Exception("Controller {$controller} not found", 404);
            }
        } else {
            throw new \Exception("No route matched for '{$url}'", 404);
        }
    }

    /**
     * Convert string to StudlyCaps
     */
    protected function convertToStudlyCaps(string $string): string
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    /**
     * Convert string to camelCase
     */
    protected function convertToCamelCase(string $string): string
    {
        return lcfirst($this->convertToStudlyCaps($string));
    }

    /**
     * Remove query string from URL
     */
    protected function removeQueryString(string $url): string
    {
        if ($url !== '') {
            $parts = explode('?', $url, 2);
            $url = $parts[0];
        }
        return $url;
    }

    public function getParams(): array
    {
        return $this->params;
    }
}
