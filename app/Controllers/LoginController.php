<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Models\UserModel;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        $model = new UserModel();

        if ($request->isPost())
        {
            $model->loadData($request->getData());
            if ($model->validate())
            {
                echo "VALIDATED";
            }
        }

        return $this->view('auth', ['model' => $model]);
    }
}