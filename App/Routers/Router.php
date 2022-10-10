<?php

declare(strict_types=1);

namespace App\Routers;

use App\View\Renderers\ViewRenderer;

abstract class Router
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
        protected array $routes,
        protected string $route_name,
        protected ViewRenderer $view_renderer
    ) {}

    /**
     * Get the rendered content for the provided route or an exit status.
     *
     * @return string|int
     */
    abstract public function route() : string|int;
}