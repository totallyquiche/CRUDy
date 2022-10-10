<?php

declare(strict_types=1);

namespace App\Views\Renderers;

interface ViewRenderer
{
    /**
     * Render the specified view.
     *
     * @param string $view_name
     * @param array  $args
     *
     * @return string
     */
    public function renderView(
        string $view_name = '',
        array $args = []
    ) : string;
}