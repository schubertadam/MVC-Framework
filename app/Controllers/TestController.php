<?php

namespace App\Controllers;

use App\Core\Controller;

class TestController extends Controller
{
    public function index()
    {
        return $this->view('test');
    }
}