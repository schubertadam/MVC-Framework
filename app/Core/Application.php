<?php

namespace App\Core;

class Application
{
    public static Application $app;
    public Router $router;
    private Request $request;
    private Response $response;
    public Controller $controller;
    public View $view;

    public function __construct()
    {
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->controller = new Controller();
        $this->view = new View();
    }

    public function run(): void
    {
        echo $this->router->resolve();
    }

    public function get(string $path, $callback) {
        $this->router->get($path, $callback);
    }

    public function post(string $path, $callback) {
        $this->router->post($path, $callback);
    }

    public function map(array $methods, string $path, $callback) {
        $this->router->map($methods, $path, $callback);
    }
}