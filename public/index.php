<?php

use App\Core\Application;

const ROOT = __DIR__ . "/../";

require_once ROOT . "/vendor/autoload.php";

$app = new Application();

//$app->router->get('', function () {
//    echo "Hello World";
//});

$app->router->get('', [\App\Controllers\TestController::class, 'index']);

$app->run();