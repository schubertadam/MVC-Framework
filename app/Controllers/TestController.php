<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;

class TestController extends Controller
{
    public function index(): array|string
    {
        return $this->view('test', ['title' => 'Test Page']);
    }

    public function mergeTest(Request $request)
    {
        if ($request->isPost())
        {
            echo "<pre>";
            var_dump($request->getData());
            echo "</pre>";
            exit;
        }

        return $this->view('test', ['title' => 'Test Page']);
    }
}