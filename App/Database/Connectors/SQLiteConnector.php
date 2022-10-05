<?php

declare(strict_types=1);

namespace App\Database\Connectors;

use App\Database\Connectors\PdoConnector;
use App\Database\Configs\DatabaseConnectorConfig;
use App\Database\Configs\SqliteConnectorConfig;
use App\Config;

final class SqliteConnector extends PdoConnector
{
    /**
     * Generate the DSN for connecting to the MySQL database.
     *
     * @param DatabaseConnectorConfig $database_connector_config
     *
     * @return string
     */
    protected function generateDsn(DatabaseConnectorConfig $database_connector_config) : string
    {
        return 'sqlite:' . ($database_connector_config->name ?? ':memory:');
    }

    /**
     * Returns a SqliteConnectorConfig to use for setting up a PDO instance.
     *
     * @return DatabaseConnectorConfig
     */
    public static function generateConnectorConfig(): DatabaseConnectorConfig
    {
        $database_connector_config = new SqliteConnectorConfig();

        $database_connector_config->name = Config::get('SQLITE_FILE_NAME');

        return $database_connector_config;
    }
}