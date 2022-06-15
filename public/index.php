<?php

use App\Core\Application;

const ROOT = __DIR__ . "/../";

require_once ROOT . "/vendor/autoload.php";

$app = new Application();

$app->router->get('', function () {
    echo "Hello World";
});

$app->run();