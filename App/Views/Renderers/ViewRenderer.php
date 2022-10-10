<?php

declare(strict_types=1);

namespace App\Views\Renderers;

abstract class ViewRenderer
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
    abstract public function renderView(
        string $view_name = '',
        array $args = []
    ) : string;
}