<?php

declare(strict_types=1);

namespace App\Views\Renderers;

interface ViewRenderer
{
    /**
     * Render the view
     *
     * @return string
     */
    public function renderView() : string;
}