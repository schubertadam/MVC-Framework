<?php

namespace App\Core;

class View
{
    /**
     * @throws \Exception
     */
    public function renderView(string $view, array $params = [])
    {
        if (empty($this->layout))
        {
            return $this->getView($view, $params);
        }

        $content = $this->getView($view, $params);
        $layout = $this->getLayout();

        $layout = str_replace("{{ slot }}", $content, $layout);

        return $layout;
    }

    /**
     * @throws \Exception
     */
    public function getLayout(): string
    {
        $layout = Application::$app->controller->layout;
        $path = ROOT . "/resources/view/layouts/$layout.php";

        if (empty($layout))
        {
            return "{{ slot }}";
        }

        if (!file_exists($path))
        {
            throw new \Exception("The required layout doesn't exists!");
        }

        ob_start();
        require_once $path;
        return ob_get_clean();
    }

    public function getView(string $view, array $params): string
    {
        // option to use variables in templates
        if (!empty($params))
        {
            foreach ($params as $key => $value)
            {
                $$key = $value; // see in controllers
            }
        }

        ob_start();
        require_once ROOT . "/resources/views/$view.php";
        return ob_get_clean();
    }
}