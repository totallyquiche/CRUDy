<?php

declare(strict_types=1);

namespace App;

use App\Routers\Router;
use App\Database\Connectors\DatabaseConnector;

final class App
{
    /**
     * Handle instantiation.
     *
     * @param Config                 $config
     * @param Router                 $router
     * @param null|DatabaseConnector $database_connector
     *
     * @return void
     */
    public function __construct(
        private Config $config,
        private Router $router,
        private ?DatabaseConnector $database_connector
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
     * @return DatabaseConnector|null
     */
    public function getDatabaseConnector() : DatabaseConnector|null
    {
        return $this->database_connector;
    }

    /**
     * Entrypoint to the application.
     *
     * @return string
     */
    public function run() : string
    {
        return $this->router ? $this->router->route() : '';
    }
}