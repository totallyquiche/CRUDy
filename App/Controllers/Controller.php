<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Views\Renderers\ViewRenderer;

abstract class Controller {
    /**
     * Handle instantiation.
     *
     * @param TemplateRenderer $template_renderer
     *
     * @return void
     */
    public function __construct(protected ViewRenderer $view_renderer) {}
}