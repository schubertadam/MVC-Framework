<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Models\TestModel;

class TestController extends Controller
{
    public function index(): array|string
    {
        return $this->view('test', ['title' => 'Test Page']);
    }

    public function mergeTest(Request $request)
    {
        $model = new TestModel();

        if ($request->isPost())
        {
            $model->loadData($request->getData());
            if ($model->validate())
            {
                echo "VALIDATED";
            }
        }

        return $this->view('test', ['title' => 'Test Page', 'model' => $model]);
    }
}