<?php

declare(strict_types=1);

namespace App\Tests;

use App\Router;
use \ReflectionObject;

final class RouterTest extends BaseTest
{
    /**
     * Test that the register function adds a route and it's controller method to
     * the routes array.
     *
     * @return bool
     */
    public function test_register_adds_route_and_controller_method_to_routes() : bool
    {
        $router = new Router;
        $route = '/path/to/somewhere';
        $controller_method = 'SomeController::action';

        $router->register($route, $controller_method);

        return ($router->getRoutes()[$route] ?? null) === $controller_method;
    }

    /**
     * Test that the callRouteMethod function correctly parses the route controller
     * method and calls it.
     *
     * @return bool
     */
    public function test_callRouteMethod_calls_correct_controller_method() : bool
    {
        $router = new Router;
        $controller_class_name = 'SomeController_' . str_replace('.', '_', (string) microtime(true));
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
     * Tests that getRoutes returns the $routes array.
     *
     * @return bool
     */
    public function test_getRoutes_returns_routes_array() : bool
    {
        $router = new Router;

        $expected_routes = [
            '/some/route/to/somewhere' => 'SomeController::method',
            '/another/route/going/places' => 'AnotherController::places',
            '/final/destination' => 'FinalDestinationController:arrive',
            '/' => 'HomeController::home'
        ];

        // Use Reflection to set private property without using other methods
        $reflection_property = (new ReflectionObject($router))->getProperty('routes');
        $reflection_property->setAccessible(true);
        $reflection_property->setValue($router, $expected_routes);
        $reflection_property->setAccessible(false);

        $routes = $router->getRoutes();

        return $expected_routes === $routes;
    }

    /**
     * Tests that setRoutes populates the routes array.
     *
     * @return bool
     */
    public function test_setRoutes_populates_routes_array() : bool
    {
        $router = new Router;

        $expected_routes = [
            '/some/route/to/somewhere' => 'SomeController::method',
            '/another/route/going/places' => 'AnotherController::places',
            '/final/destination' => 'FinalDestinationController:arrive',
            '/' => 'HomeController::home'
        ];

        $router->setRoutes($expected_routes);

        return $router->getRoutes() === $expected_routes;
    }
}