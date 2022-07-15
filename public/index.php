<?php

use App\Controllers\LoginController;
use App\Core\Application;

const ROOT = __DIR__ . "/../";
const DEBUG = true;

require_once ROOT . "/vendor/autoload.php";

$app = new Application();

$app->map(['post', 'get'],'', LoginController::class);
//$app->get('', [LoginController::class, 'index']);
//$app->map(['post', 'get'], '', [LoginController::class, 'login']);

$app->run();