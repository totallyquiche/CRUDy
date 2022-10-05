<?php

declare(strict_types=1);

namespace App;

require_once(__DIR__ . '/bootstrap.php');

(function () {
    require_once(__DIR__ . '/routes.php');

    $router = new Router;

    foreach ($routes as $key => $value) {
        $router->register($key, $value);
    }

    echo $router->callRouteMethod($_SERVER['REQUEST_URI']);
})();