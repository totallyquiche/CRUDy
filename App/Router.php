<?php

declare(strict_types=1);

namespace App;

use App\Controllers\Http\HttpController;
use App\Views\Renderers\ViewRenderer;

class Router
{
    /**
     * Handle initialization.
     *
     * @param array        $routes
     * @param string       $request_rui
     * @param ViewRenderer $view_renderer
     *
     * @return void
     */
    public function __construct(
        private array $routes,
        private string $request_uri,
        private ViewRenderer $view_renderer
    ) {}

    /**
     * Get the rendered content for the provided route.
     *
     * @return string;
     */
    public function route() : string
    {
        // Headless
        if ($this->request_uri === '') {
            return '';
        }

        $router_handler = $this->routes[$this->request_uri] ?? null;

        // Callable
        if (is_callable($router_handler)) {
            return $router_handler();
        }

        // Controller
        if (is_array($router_handler)) {
            $controller_class = $router_handler[0];
            $method = $router_handler[1];

            return (new $controller_class($this->view_renderer))->$method();
        }

        // Missing route
        return (new HttpController($this->view_renderer))->http404();
    }
}