<?php

declare(strict_types=1);

namespace App\Controllers\Http;

use App\Controllers\Controller;
use App\Views\Renderers\TemplateRenderer;

class HttpController extends Controller
{
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