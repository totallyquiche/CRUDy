<?php

declare(strict_types=1);

namespace App;

use App\Database\Connectors\DatabaseConnector;
use App\Views\ViewRenderer;

final class App
{
    /**
     * Handle instantiation.
     *
     * @param Config            $config
     * @param DatabaseConnector $database_connector
     *
     * @return void
     */
    public function __construct(
        private Config $config,
        private DatabaseConnector $database_connector
    ) {}

    /**
     * Return Config.
     *
     * @return Config
     */
    public function getConfig() : Config
    {
        return $this->config;
    }

    /**
     * Return DatabaseConnector.
     *
     * @return DatabaseConnector
     */
    public function getDatabaseConnector() : DatabaseConnector
    {
        return $this->database_connector;
    }

    /**
     * Entrypoint to the application.
     *
     * @return void
     */
    public function run() : void
    {
        $request_uri = $_SERVER['REQUEST_URI'] ?? null;

        if (!is_null($request_uri)) {
            $view_renderer = new ViewRenderer(
                $this->config->get('SITE_TITLE'),
                $this->config->get('SITE_URL'),
                intval($this->config->get('VIEW_CACHE_SECONDS_TO_EXPIRY'))
            );

            require_once(__DIR__ . '/../routes.php');

            $router = new Router(
                $routes,
                $view_renderer,
                $this->database_connector
            );

            foreach ($routes as $key => $value) {
                $router->register($key, $value);
            }

            echo $router->route($request_uri);
        }
    }
}