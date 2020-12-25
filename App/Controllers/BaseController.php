<?php declare(strict_types=1);

namespace App\Controllers;

abstract class BaseController
{
    /**
     * Returns the contents of the specified view.
     *
     * @param string $view_name
     * @param array  $args
     *
     * @return string
     */
    protected function loadView(string $view_name, array $args) : string
    {

        foreach ($args as $key => $value) {
            $$key = $value;
        }

        ob_start();

        include(__DIR__ . '/../Views/' . $view_name . '.php');

        return ob_get_clean();
    }
}