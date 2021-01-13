<?php declare(strict_types=1);

namespace App;

use App\Controllers\HttpController;

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
     * Get the rendered content for the provided request.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function callRouteMethod(Request $request) : Response
    {
        $route = parse_url($request->getUri(), PHP_URL_PATH);
        $method = $this->routes[$route];

        if (is_callable($method)) {
            $response_data = $method();
        } elseif (isset($this->routes[$route])) {
            list($controller, $method) = explode('::', $this->routes[$route]);

            $class = 'App\\Controllers\\' . $controller;

            $response_data = (new $class)->$method($request);

        } else {
            $response_data = (new HttpController)->http404($request);
        }

        return new Response($response_data);
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