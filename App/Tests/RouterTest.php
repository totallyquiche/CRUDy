<?php declare(strict_types=1);

namespace App\Tests;

use App\Router;

class RouterTest implements TesterInterface
{
    /**
     * Test that the register function adds a route and it's controller method to
     * the routes array.
     *
     * @param Router $router
     *
     * @return bool
     */
    public function test_register_adds_route_and_controller_method_to_routes(Router $router) : bool
    {
        $route = '/path/to/somewhere';
        $controller_method = 'SomeController::action';

        $router->register($route, $controller_method);

        return ($router->getRoutes()[$route] ?? null) === $controller_method;
    }

    /**
     * Run the tests.
     *
     * @return bool
     */
    public function run() : bool
    {
        $router = new Router;

        return $this->test_register_adds_route_and_controller_method_to_routes($router);
    }
}