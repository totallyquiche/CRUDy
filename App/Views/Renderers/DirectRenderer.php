<?php

declare(strict_types=1);

namespace App\Views\Renderers;

final class DirectRenderer implements ViewRenderer
{
    /**
     * Render the specified view.
     *
     * @return string
     */
    public function renderView(string $content = '') : string
    {
        return $content;
    }
}