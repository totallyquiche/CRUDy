<?php declare(strict_types=1);

namespace App\Controllers;

class HomeController extends BaseController
{
    /**
     * Returns the contents of the specified view.
     *
     * @return string
     */
    public function home() : string
    {
        return $this->loadView('home');
    }
}