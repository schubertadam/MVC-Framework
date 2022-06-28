<?php

namespace App\Core;

class Request
{
    public function getMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function isGet(): bool
    {
        return $this->getMethod() === 'get';
    }

    public function isPost(): bool
    {
        return $this->getMethod() === 'post';
    }

    public function isAjax(): bool {
        return strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }

    public function getPath(): string
    {
        $url = $_SERVER['REQUEST_URI'];
        $position = strpos($url, '?');

        return !$position? $url : substr($url, 0, $position);
    }

    public function getData(): array {
        $data = [];
        $data += $_GET += $_POST;
        $this->filter($data);

        return $data;
    }

    /** Prevent attacks by filtering
     * @param array $data
     */
    private function filter(array &$data): void {
        array_walk_recursive($data, function(&$value) {
            $value = filter_var(trim($value), FILTER_SANITIZE_STRING);
        });
    }
}