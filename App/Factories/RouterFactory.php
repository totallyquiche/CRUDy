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
     * @return Router
     */
    public static function create(
        array  $routes,
        string $request_uri,
        ViewRenderer $view_renderer
    ) : Router
    {
        return new Router(
            $routes,
            $request_uri,
            $view_renderer
        );
    }
}