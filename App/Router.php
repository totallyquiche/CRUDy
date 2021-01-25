<?php declare(strict_types=1);

namespace App;

use App\Controllers\HttpController;
use App\Http\Request;

use function \getallheaders;

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
     * $route is the route key and $method a key => pair
     * value with the HTTP method and controller method to use like
     * 'GET' => 'HomeController::index' or 'GET' => Callable.
     *
     * @param string $route
     * @param array  $methods
     *
     * @return void
     */
    public function register(string $route, array $methods) : void
    {
        foreach ($methods as $key => $value) {
            $this->routes[$route][strtoupper($key)] = $value;
        }
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
        $request = new Request(
            $_SERVER['REQUEST_METHOD'] ?? '',
            $this->getHeaders()
        );

        $method = $this->routes[$route][strtoupper($request->getMethod())] ?? '';

        if (is_callable($method)) {
            return $method($request);
        } elseif ($method) {
            list($controller, $method) = explode('::', $method);

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

    /**
     * Get the request headers.
     *
     * @return array
     */
    private function getHeaders() : array
    {
        $headers = [];

        if (!function_exists('getallheaders')) {
            foreach ($_SERVER as $name => $value) {
                if (substr($name, 0, 5) == 'HTTP_') {
                    $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
                }
            }
        } else {
            $headers = getallheaders();
        }

        return $headers;
    }
}