<?php

namespace App\Core;

class Application
{
    public Router $router;
    private Request $request;

    public function __construct()
    {
        $this->request = new Request();
        $this->router = new Router($this->request);
    }

    public function run(): void
    {
        echo $this->router->resolve();
    }
}