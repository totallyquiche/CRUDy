<?php declare(strict_types=1);

namespace App;

class Router
{
    /**
     * Route registrar.
     *
     * @var array
     */
    private array $routes = [];

    /**
     * Register a route.
     *
     * $route is the route key and $controller_method is the value in the format
     * ControllerName::methodName. This determines which controller method should
     * handle the route.
     *
     * @param string $route
     * @param string $controller_method
     *
     * @return void
     */
    public function register(string $route, string $controller_method) : void
    {
        $this->routes[$route] = $controller_method;
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
        list($controller, $method) = explode('::', $this->routes[$route]);

        $class = 'App\\Controllers\\' . $controller;

        return (new $class)->$method();
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
}