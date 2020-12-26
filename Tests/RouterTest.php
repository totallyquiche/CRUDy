<?php declare(strict_types=1);

namespace Tests;

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
     * Test that the callRouteMethod function correctly parses the route controller
     * method and calls it.
     *
     * @param Router $router
     *
     * @return bool
     */
    public function test_callRouteMethod_calls_correct_controller_method(Router $router) : bool
    {
        $controller_class_name = 'SomeController';
        $random_number = (string) mt_rand();

        $controller_class_definition = <<<CLASS
            namespace App\Controllers;

            class {$controller_class_name} {
                public function action() : string
                {
                    return'{$random_number}';
                }
            }
        CLASS;

        eval($controller_class_definition);

        $route = '/route/to/something';
        $controller_method = $controller_class_name . '::action';

        $router->register($route, $controller_method);

        return $router->callRouteMethod($route) === $random_number;
    }

    /**
     * Run the tests.
     *
     * @return bool
     */
    public function run() : bool
    {
        return
            $this->test_register_adds_route_and_controller_method_to_routes(new Router) &&
            $this->test_callRouteMethod_calls_correct_controller_method(new Router);

    }
}