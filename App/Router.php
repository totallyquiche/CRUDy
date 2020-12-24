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
     * @param string   $route
     * @param Callable $callable
     *
     * @return void
     */
    public function register(string $route, Callable $callable) : void
    {
        $this->routes[$route] = $callable;
    }

    /**
     * Given a route, invoke the registered callable.
     *
     * @param string $route
     *
     * @return void;
     */
    public function callRouteCallable(string $route) : void
    {
        $this->routes[$route]();
    }
}