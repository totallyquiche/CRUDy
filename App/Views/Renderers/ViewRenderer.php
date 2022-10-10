<?php

declare(strict_types=1);

namespace App\Views\Renderers;

interface ViewRenderer
{
    /**
     * Render the specified view.
     *
     * @return string
     */
    public function renderView() : string;
}