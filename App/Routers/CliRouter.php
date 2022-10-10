<?php

declare(strict_types=1);

namespace App\Routers;

use App\View\Renderers\ViewRenderer;

class CliRouter extends Router
{
    /**
     * Handle initialization.
     *
     * @param array        $routes
     * @param string       $request_rui
     * @param ViewRenderer $view_renderer
     * @param array        $args
     *
     * @return void
     */
    public function __construct(
        array $routes,
        string $route_name,
        ViewRenderer $view_renderer,
        protected array $args
    ) {
        parent::__construct($routes, $route_name, $view_renderer, $args);
    }

    /**
     * Get the rendered content for the provided route.
     *
     * @return string|int
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

            return (
                new $controller_class($this->view_renderer, $this->args)
            )->$method();
        }

        // Missing route
        return 127;
    }
}