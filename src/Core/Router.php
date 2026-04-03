<?php

declare(strict_types=1);

namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $pattern, string $controller, string $method): void
    {
        $this->routes[] = [
            'pattern' => $pattern,
            'controller' => $controller,
            'method' => $method,
        ];
    }

    public function dispatch(string $uri): void
    {
        $uri = parse_url($uri, PHP_URL_PATH);
        $uri = rtrim($uri, '/') ?: '/';

        foreach ($this->routes as $route) {
            $regex = $this->patternToRegex($route['pattern']);

            if (preg_match($regex, $uri, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                $controllerClass = $route['controller'];
                $method = $route['method'];

                if (!class_exists($controllerClass)) {
                    $this->sendNotFound();
                    return;
                }

                $controller = new $controllerClass();

                if (!method_exists($controller, $method)) {
                    $this->sendNotFound();
                    return;
                }

                $controller->$method(...array_map('intval', $params));
                return;
            }
        }

        $this->sendNotFound();
    }

    private function patternToRegex(string $pattern): string
    {
        $regex = preg_replace('/\{(\w+)\}/', '(?P<$1>\d+)', $pattern);
        return '#^' . $regex . '$#';
    }

    private function sendNotFound(): void
    {
        http_response_code(404);
        $controller = new \App\Controllers\HomeController();
        $controller->notFound();
    }
}
