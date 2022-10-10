<?php

declare(strict_types=1);

namespace App\Tests\Mocks;

use App\Controllers\Controller as RealController;
use App\Views\Renderers\PlainTextRenderer;

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
     * @param PlainTextRenderer $template_renderer
     *
     * @return void
     */
    public function __construct(PlainTextRenderer $view_renderer)
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
        $this->view_renderer->setContent(self::CONTENT);

        return $this->view_renderer->renderView();
    }
}