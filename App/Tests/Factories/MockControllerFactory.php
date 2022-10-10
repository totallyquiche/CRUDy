<?php

declare(strict_types=1);

namespace App\Tests\Factories;

use App\Tests\Mocks\Controller as MockController;
use App\Views\Renderers\ViewRenderer;

final class MockControllerFactory
{
    /**
     * Create a mock instance of Controller.
     *
     * @return MockController
     */
    public static function create(ViewRenderer $view_renderer) : MockController
    {
        return new MockController($view_renderer);
    }
}