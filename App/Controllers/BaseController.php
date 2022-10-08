<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Views\ViewRenderer;

abstract class BaseController
{
    /**
     * @var ViewRenderer
     */
    private ViewRenderer $view_renderer;

    /**
     * Setter method.
     *
     * @param ViewRenderer $view_renderer
     *
     * @return void
     */
    public function setViewRenderer(ViewRenderer $view_renderer) : void
    {
        $this->view_renderer = $view_renderer;
    }

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