<?php

namespace App\Core;

use App\Exceptions\FileNotExists;

class View
{
    /**
     * @throws \Exception
     */
    public function renderView(string $view, array $params = []): array|string
    {
        $content = $this->getView($view, $params);

        if (empty(Application::$app->controller->layout))
        {
            return $content;
        }

        return str_replace("{{ slot }}", $content, $this->getLayout());
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
            throw new FileNotExists($layout);
        }

        ob_start();
        require_once $path;
        return ob_get_clean();
    }

    public function getView(string $view, array $params): string
    {
        $path = ROOT . "/resources/views/$view.php";

        if (!file_exists($path))
        {
            throw new FileNotExists($view);
        }

        // option to use variables in templates
        if (!empty($params))
        {
            foreach ($params as $key => $value)
            {
                $$key = $value; // see in controllers
            }
        }

        ob_start();
        require_once $path;
        return ob_get_clean();
    }
}