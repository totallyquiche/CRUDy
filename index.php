<?php declare(strict_types=1);

require_once(__DIR__ . '/vendor/autoload.php');

use App\Router;

$router = new Router;

$router->register('/', function () {
    echo 'Hello, World!';
});

$router->callRouteCallable($_SERVER['REQUEST_URI']);