<?php

declare(strict_types=1);

namespace App;

use App\Routers\Router;
use App\Database\Connectors\DatabaseConnector;

final class App
{
    /**
     * Static instance of this class (Singleton pattern).
     *
     * @var App
     */
    static App $self;

    /**
     * Handle instantiation.
     *
     * @param Config                 $config
     * @param Router                 $router
     * @param null|DatabaseConnector $database_connector
     *
     * @return void
     */
    private function __construct(
        private Config $config,
        private Router $router,
        private ?DatabaseConnector $database_connector
    ) {}

    /**
     * Return Config.
     *
     * @return Config
     */
    public static function getConfig() : Config
    {
        return self::$self->config;
    }

    /**
     * Return DatabaseConnector.
     *
     * @return DatabaseConnector|null
     */
    public static function getDatabaseConnector() : DatabaseConnector|null
    {
        return self::$self->database_connector;
    }

    /**
     * Execute the application.
     *
     * @return string
     */
    private function run() : string
    {
        exit($this->router ? $this->router->route() : 0);
    }

    /**
     * Instantiate the application.
     *
     * @param Config                 $config
     * @param Router                 $router
     * @param null|DatabaseConnector $database_connector
     *
     * @return void
     */
    public static function init(
        Config $config,
        Router $router,
        ?DatabaseConnector $database_connector
    ) : void
    {
        self::$self = new self(
            $config,
            $router,
            $database_connector
        );

        self::$self->run();
    }
}