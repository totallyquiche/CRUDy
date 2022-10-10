<?php

declare(strict_types=1);

namespace App\Views\Renderers;

final class CliRenderer implements ViewRenderer
{
    /**
     * @var string
     */
    protected string $content;

    /**
     * Setter method.
     *
     * @param string $content
     *
     * @return void
     */
    public function setContent(string $content) : void
    {
        $this->content = $content;
    }

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