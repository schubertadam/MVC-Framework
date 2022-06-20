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
}