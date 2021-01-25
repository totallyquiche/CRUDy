<?php declare(strict_types=1);

namespace App;

use App\Controllers\HttpController;
use App\Http\Request;

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
        $method = $this->routes[$route];
        $request = new Request($_SERVER['REQUEST_METHOD'] ?? '');

        if (is_callable($method)) {
            return $method($request);
        } elseif (isset($this->routes[$route])) {
            list($controller, $method) = explode('::', $this->routes[$route]);

            $class = 'App\\Controllers\\' . $controller;

            return (new $class)->$method($request);
        } else {
            return (new HttpController)->http404($request);
        }
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