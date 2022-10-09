<?php

declare(strict_types=1);

namespace App\Controllers;

class HomeController extends Controller
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