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
        $routes[$route] = $callable;
    }
}