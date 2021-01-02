<?php declare(strict_types=1);

require_once(__DIR__ . '/bootstrap.php');

use App\Router;

(function () {
    $router = new Router;

    $router->register('/', 'HomeController::index');

    echo $router->callRouteMethod($_SERVER['REQUEST_URI']);
})();