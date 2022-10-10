<?php

declare(strict_types=1);

namespace App\Cli\Controllers;

use App\Controller;
use App\View\Renderers\ViewRenderer;

abstract class CliController extends Controller {
    /**
     * Handle instantiation.
     *
     * @param TemplateRenderer $template_renderer
     *
     * @return void
     */
    public function __construct(
        ViewRenderer $view_renderer,
        protected array $args
    )
    {
        parent::__construct($view_renderer);
    }
}