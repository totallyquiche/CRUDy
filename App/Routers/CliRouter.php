<?php

declare(strict_types=1);

namespace App\Routers;

class CliRouter extends Router
{
    /**
     * Get the rendered content for the provided route.
     *
     * @return string;
     */
    public function route() : string
    {
        $this->view_renderer->setContent('');

        return $this->view_renderer->renderView();
    }
}