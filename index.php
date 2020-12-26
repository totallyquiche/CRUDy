<?php declare(strict_types=1);

require_once(__DIR__ . '/bootstrap.php');

use App\Router;

(function () {
    $router = new Router;

    $router->register('/', function () {
        return 'Hello, World!';
    });

    $router->register(
        '/thingamabob',
        'ThingamabobController::index'
    );

    echo $router->callRouteMethod($_SERVER['REQUEST_URI']);
})();