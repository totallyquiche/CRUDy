<?php

declare(strict_types=1);

namespace App\Controllers\Http;

use App\Controllers\Controller;
use App\Views\Renderers\TemplateRenderer;

class HttpController extends Controller
{
    /**
     * Handle instantiation.
     *
     * @param TemplateRenderer $template_renderer
     *
     * @return void
     */
    public function __construct(TemplateRenderer $view_renderer)
    {
        parent::__construct($view_renderer);
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
        $this->view_renderer->setViewName($view_name);
        $this->view_renderer->setArgs($args);

        return $this->view_renderer->renderView();
    }

    /**
     * Render the home page.
     *
     * @return string
     */
    public function http404() : string
    {
        http_response_code(404);

        return $this->renderView('404');
    }
}