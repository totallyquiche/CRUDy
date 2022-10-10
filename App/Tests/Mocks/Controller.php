<?php

declare(strict_types=1);

namespace App\Tests\Mocks;

use App\Controller as RealController;
use App\Views\Renderers\DirectRenderer;

final class Controller extends RealController {
    /**
     * Content to be rendered by the controller.
     *
     * @const string
     */
    private const CONTENT = 'CONTENT';

    /**
     * Handle instantiation.
     *
     * @param DirectRenderer $template_renderer
     *
     * @return void
     */
    public function __construct(DirectRenderer $view_renderer)
    {
        parent::__construct($view_renderer);
    }

    /**
     * Render the default view.
     *
     * @return string
     */
    public function index() : string
    {
        return $this->view_renderer->renderView(self::CONTENT);
    }
}