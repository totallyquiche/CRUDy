<?php declare(strict_types=1);

require_once(__DIR__ . '/bootstrap.php');

use App\Router;

(function () {
    $routes = [
        '/' => 'HomeController::index'
    ];

    $router = new Router;

    foreach ($routes as $key => $value) {
        $router->register($key, $value);
    }

    echo $router->callRouteMethod(
        parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
    );
})();