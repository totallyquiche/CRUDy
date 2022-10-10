<?php

declare(strict_types=1);

namespace App\Views\Renderers;

final class CliRenderer extends ViewRenderer
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
    ) : string
    {
        return $this->content;
    }
}