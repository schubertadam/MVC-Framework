<?php

use App\Core\Application;

const ROOT = __DIR__ . "/../";
const DEBUG = true;

require_once ROOT . "/vendor/autoload.php";

$app = new Application();

//$app->router->get('', function () {
//    echo "Hello World";
//});

//$app->router->get('', [\App\Controllers\TestController::class, 'index']);
//$app->router->get('', 'test');
$app->map(['post', 'get'], '', [\App\Controllers\TestController::class, 'mergeTest']);

$app->run();