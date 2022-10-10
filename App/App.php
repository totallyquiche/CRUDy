<?php

declare(strict_types=1);

namespace App;

use App\Database\Connectors\DatabaseConnector;

final class App
{
    /**
     * Handle instantiation.
     *
     * @param Config            $config
     * @param DatabaseConnector $database_connector
     * @param null|Router       $router
     *
     * @return void
     */
    public function __construct(
        private Config $config,
        private DatabaseConnector $database_connector,
        private Router $router
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
        echo $this->router->route();
    }
}