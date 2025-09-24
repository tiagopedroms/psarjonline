<?php

namespace App\Lib;

class Router
{
    private array $routes = [];

    public function add(string $route, callable $handler): void
    {
        $this->routes[$route] = $handler;
    }

    public function dispatch(string $route): void
    {
        if (!isset($this->routes[$route])) {
            http_response_code(404);
            echo 'Página não encontrada';
            return;
        }

        call_user_func($this->routes[$route]);
    }
}
