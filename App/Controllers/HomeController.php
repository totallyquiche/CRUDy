<?php declare(strict_types=1);

namespace App\Controllers;

class HomeController extends BaseController
{
    /**
     * Render the home page.
     *
     * @return string
     */
    public function index() : string
    {
        return $this->loadView('home', [
            'header_text' => 'Hello, World!'
        ]);
    }
}