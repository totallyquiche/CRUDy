<?php declare(strict_types=1);

namespace App\Controllers;

abstract class BaseController
{
    /**
     * Returns the contents of the specified view.
     *
     * @param string $view_name
     *
     * @return string
     */
    protected function loadView(string $view_name) : string
    {
        return file_get_contents(__DIR__ . '/../Views/' . $view_name . '.php');
    }
}