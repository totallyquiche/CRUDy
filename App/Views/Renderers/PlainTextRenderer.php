<?php

declare(strict_types=1);

namespace App\Views\Renderers;

final class PlainTextRenderer implements ViewRenderer
{
    /**
     * The content to render.
     *
     * @var string
     */
    private string $content;

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
     * @param string $content
     *
     * @return string
     */
    public function renderView() : string {
        return $this->content;
    }
}