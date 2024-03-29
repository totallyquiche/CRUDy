<?php

declare(strict_types=1);

namespace App\Tests;

use App\App;
use App\Tests\Attributes\DataProvider;
use App\Tests\Helpers\TestHelper;
use App\Http\HttpRouter;
use App\View\Renderers\DirectRenderer;
use App\Tests\Factories\MockControllerFactory;
use App\Tests\Mocks\Controller as MockController;
use App\Http\Controllers\HttpController;
use App\View\Renderers\TemplateRenderer;

final class RouterTest extends Test
{
    /**
     * Route data provider.
     *
     * @return array
     */
    public function routesProvider() : array
    {
        $random_string = TestHelper::getRandomString();
        $mock_controller = MockControllerFactory::create(new DirectRenderer);

        return [
            'Route to callable' => [
                'data' => ['/' => fn() => $random_string],
                'expected_results' => $random_string,
            ],
            'Route to Controller' => [
                'data' => ['/' => [MockController::class, 'index']],
                'expected_results' => $mock_controller->index()
            ],
        ];
    }

    /**
     * Test that route returns the expected strings.
     *
     * @param array  $routes
     * @param string $expected_results
     *
     * @return bool
     */
    #[DataProvider('routesProvider')]
    public function test_route(array $routes, string $expected_results) : bool
    {
        foreach ($routes as $request_uri => $route_handler) {
            $router = new HttpRouter(
                $routes,
                $request_uri,
                new DirectRenderer
            );

            if ($router->route() !== $expected_results) {
                return false;
            }
        }

        return true;
    }

    /**
     * Test that route returns the expected results when the route is missing.
     *
     * @return bool
     */
    public function test_missing_route() : bool
    {
        $template_renderer = new DirectRenderer;

        $router = new HttpRouter(
            [TestHelper::getRandomString(1) => ''],
            TestHelper::getRandomString(2),
            $template_renderer
        );

        if (
            $router->route() !==
                (new HttpController($template_renderer))->http404()
        ) {
            return false;
        }

        return true;
    }
}