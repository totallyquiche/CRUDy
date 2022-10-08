<?php

declare(strict_types=1);

namespace App;

use App\Controllers\HttpController;
use App\Views\ViewRenderer;

class Router
{
    /**
     * Handle initialization.
     *
     * @param array        $routes
     * @param ViewRenderer $view_renderer
     *
     * @return void
     */
    public function __construct(
        private array $routes,
        private ViewRenderer $view_renderer
    ) {}

    /**
     * Register a route.
     *
     * $route is the route key and $method is either a string in the format
     * ControllerName::methodName or a Callable.
     *
     * @param string          $route
     * @param string|callable $method
     *
     * @return void
     */
    public function register(string $route, $method) : void
    {
        $this->routes[$route] = $method;
    }

    /**
     * Get the rendered content for the provided route.
     *
     * @param string $route
     *
     * @return string;
     */
    public function callRouteMethod(string $route) : string
    {
        if (isset($this->routes[$route])) {
            $method = $this->routes[$route];

            if (is_callable($method)) {
                return $method();
            }

            list($controller_name, $method) = explode('::', $this->routes[$route]);

            $controller_class = 'App\\Controllers\\' . $controller_name;
            $controller = new $controller_class;
            $controller->setViewRenderer($this->view_renderer);

            return $controller->$method();
        }

        return (new HttpController)->http404();
    }

    /**
     * Getter for $routes.
     *
     * @return array
     */
    public function getRoutes() : array
    {
        return $this->routes;
    }

    /**
     * Setter for $routes.
     *
     * @param array $routes
     *
     * @return void
     */
    public function setRoutes(array $routes) : void
    {
        $this->routes = $routes;
    }
}