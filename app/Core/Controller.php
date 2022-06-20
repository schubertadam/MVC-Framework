<?php

namespace App\Core;

class Controller
{
    public string $layout = "";

    public function view(string $view, array $params = [])
    {
        return Application::$app->view->renderView($view, $params);
    }
}