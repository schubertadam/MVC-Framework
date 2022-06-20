<?php

namespace App\Core;

class Router
{
    private array $routes;
    private Request $request;
    private Response $response;

    public function __construct(Request $request, Response $response)
    {
        $this->routes = [];
        $this->request = $request;
        $this->response = $response;
    }

    public function get(string $path, $callback): void
    {
        $this->routes['get'][$this->getPath($path)] = $callback;
    }

    public function post(string $path, $callback): void
    {
        $this->routes['post'][$this->getPath($path)] = $callback;
    }

    public function map(array $methods, string $path, $callback): void
    {
        foreach($methods as $method) {
            $this->routes[$method][$this->getPath($path)] = $callback;
        }
    }

    private function getPath($path): string
    {
        if (empty($path))
        {
            $path = "/";
        }
        
        if (!str_starts_with($path, "/")) // PHP 7.0 or older: strpos($path, "/") == 0
        {
            $path = "/" . $path;
        }

        return $path;
    }

    public function resolve()
    {
        $path = $this->request->getPath() ?? "/";
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;

        if (!$callback)
        {
            $this->response->setStatusCode(404);
            return "Page not found!";
        }

        if (is_array($callback))
        {
            Application::$app->controller = new $callback[0]; // the name of the Controller
            $callback[0] = Application::$app->controller;
        }

        return call_user_func($callback, $this->request, $this->response);
    }
}