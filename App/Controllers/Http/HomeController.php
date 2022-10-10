<?php

declare(strict_types=1);

namespace App\Controllers\Http;

class HomeController extends HttpController
{
    /**
     * Render the home page.
     *
     * @return string
     */
    public function index() : string
    {
        return $this->renderView('home');
    }
}