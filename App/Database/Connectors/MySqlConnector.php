<?php

declare(strict_types=1);

namespace App\Database\Connectors;

use App\Database\Connectors\PdoConnector;
use App\Database\Configs\DatabaseConnectorConfig;
use App\Database\Configs\MySqlConnectorConfig;
use App\Config;

final class MySqlConnector extends PdoConnector
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
        $host = $database_connector_config->host;
        $port = $database_connector_config->port;
        $name = $database_connector_config->name;

        return "mysql:host=$host;port=$port;dbname=$name;charset=utf8mb4";
    }

    /**
     * Returns a MySqlConnectorConfig to use for setting up a PDO instance.
     *
     * @return DatabaseConnectorConfig
     */
    public static function generateConnectorConfig(): DatabaseConnectorConfig
    {
        $database_connector_config = new MySqlConnectorConfig();

        $database_connector_config->host = Config::get('MYSQL_DB_HOST');
        $database_connector_config->name = Config::get('MYSQL_DB_NAME');
        $database_connector_config->user = Config::get('MYSQL_DB_USER');
        $database_connector_config->password = Config::get('MYSQL_DB_PASSWORD');
        $database_connector_config->port = Config::get('MYSQL_DB_PORT');

        return $database_connector_config;
    }
}