<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Views\ViewRenderer;

abstract class Controller
{
    /**
     * Handle instantiation.
     *
     * @param ViewRenderer $view_renderer
     *
     * @return void
     */
    public function __construct(private ViewRenderer $view_renderer) {}

    /**
     * Returns the contents of the specified view.
     *
     * @param string     $view_name
     * @param array|null $args
     *
     * @return string
     */
    protected function renderView(string $view_name, array $args = []) : string
    {
        return $this->view_renderer->renderView($view_name, $args);
    }
}