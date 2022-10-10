<?php

declare(strict_types=1);

namespace App\Factories;

use App\Router;
use App\Views\Renderers\ViewRenderer;

final class RouterFactory
{
    /**
     * Create an instance of Router.
     *
     * @param array  $routes
     * @param string $route_name
     *
     * @return Router
     */
    public static function create(
        array  $routes,
        string $route_name,
        ViewRenderer $view_renderer
    ) : Router
    {
        return new Router(
            $routes,
            $route_name,
            $view_renderer
        );
    }
}