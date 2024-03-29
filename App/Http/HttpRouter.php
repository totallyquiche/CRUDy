<?php

declare(strict_types=1);

namespace App\Http;

use App\Router;

use App\Http\Controllers\HttpController;

class HttpRouter extends Router
{
    /**
     * Get the rendered content for the provided route.
     *
     * @return string|int;
     */
    public function route() : string|int
    {
        $router_handler = $this->routes[$this->route_name] ?? null;

        // Callable
        if (is_callable($router_handler)) {
            return $router_handler();
        }

        // Controller
        if (is_array($router_handler)) {
            $controller_class = $router_handler[0];
            $method = $router_handler[1];

            return (new $controller_class($this->view_renderer))->$method();
        }

        // Missing route
        return (new HttpController($this->view_renderer))->http404();
    }
}