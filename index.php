<?php declare(strict_types=1);

require_once(__DIR__ . '/bootstrap.php');

use App\Router;

(function () {
    $routes = [
        '/' => [
            'GET' => 'HomeController::index'
        ]
    ];

    $router = new Router;

    foreach ($routes as $key => $value) {
        $router->register($key, $value);
    }

    echo $router->callRouteMethod(explode('?', $_SERVER['REQUEST_URI'], 2)[0]);
})();