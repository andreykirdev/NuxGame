<?php

namespace Routes;
class Router
{
    private $routes = [];

    public function addRoute($pattern, $callback)
    {
        $this->routes[$pattern] = $callback;
    }

    public function dispatch($path)
    {
        foreach ($this->routes as $pattern => $callback) {
            if (preg_match($pattern, $path, $matches)) {
                return call_user_func_array($callback, array_slice($matches, 1));
            }
        }
        http_response_code(404);
        echo "404 Not Found";
    }
}
