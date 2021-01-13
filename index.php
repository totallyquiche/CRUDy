<?php declare(strict_types=1);

require_once(__DIR__ . '/bootstrap.php');

use App\Router;
use App\Request;

(function () {
    $routes = [
        '/' => 'HomeController::index'
    ];

    $router = new Router;

    foreach ($routes as $key => $value) {
        $router->register($key, $value);
    }

    echo $router->callRouteMethod(
        new Request(
            $_SERVER['REQUEST_URI'],
            $_SERVER['REQUEST_METHOD']
        )
    );
})();