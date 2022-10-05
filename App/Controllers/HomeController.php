<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Database\Connectors\SqliteConnector;
use App\Config;

class HomeController extends BaseController
{
    /**
     * Render the home page.
     *
     * @return string
     */
    public function index() : string
    {
        return $this->loadView('home');
    }
}