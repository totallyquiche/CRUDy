<?php

declare(strict_types=1);

namespace App\Database\Connectors;

use App\Database\Configs\DatabaseConnectorConfig;

interface DatabaseConnector
{
    /**
     * Generate an instance of DatabaseConnectorConfig for the connector.
     *
     * @return DatabaseConnectorConfig
     */
    public static function generateConnectorConfig() : DatabaseConnectorConfig;

    /**
     * Singleton to ensure we always use the same instance of this interface.
     *
     * @param DatabaseConnectorConfig|null
     *
     * @return self
     */
    public static function getInstance(DatabaseConnectorConfig $database_connector_config = null) : self;

    /**
     * Run a query and get the results.
     *
     * @param string $query
     *
     * @return array
     */
    public function query(string $query) : array;

    /**
     * Execute a query.
     *
     * @param string $query
     *
     * @return void
     */
    public function execute(string $query) : void;
}