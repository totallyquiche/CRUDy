<?php declare(strict_types=1);

namespace App\Controllers;

class HomeController extends BaseController
{
    /**
     * Display the home page.
     *
     * @return string
     */
    public function home() : string
    {
        return 'Hello, world!';
    }
}