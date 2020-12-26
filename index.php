<?php declare(strict_types=1);

use App\Router;

require_once(__DIR__ . '/bootstrap.php');

(function () {
    $router = new Router;

    $router->register('/', 'HomeController::home');
    $router->register('/thingamabob', 'ThingamabobController::index');

    echo $router->callRouteMethod($_SERVER['REQUEST_URI']);
})();