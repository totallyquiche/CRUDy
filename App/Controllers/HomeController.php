<?php declare(strict_types=1);

namespace App\Controllers;

use App\Http\Request;

class HomeController extends BaseController
{
    /**
     * Render the home page.
     *
     * @param Request $request
     *
     * @return string
     */
    public function index(Request $request) : string
    {
        return $this->loadView('page', [
            'header_text' => 'Hello, World!'
        ]);
    }
}