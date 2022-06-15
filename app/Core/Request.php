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

    public function getPath(): string
    {
        $url = $_SERVER['REQUEST_URI'];
        $position = strpos($url, '?');

        return !$position? $url : substr($url, 0, $position);
    }
}