<?php

declare(strict_types=1);

namespace App\Database\Connectors\Factories;

use App\Database\Connectors\DatabaseConnector;
use App\Database\Connectors\Factories\MySqlConnectorFactory;
use App\Database\Connectors\Factories\SqliteConnectorFactory;

final class DatabaseConnectorFactory
{
    /**
     * Create an isntance of DatabaseConnector.
     *
     * @param string $db_driver
     * @param string $mysql_db_host
     * @param string $mysql_db_name
     * @param string $mysql_db_port
     * @param string $mysql_db_username
     * @param string $mysql_db_password
     * @param string $sqlite_db_name
     *
     * @return DatabaseConnector
     */
    public static function create(
        string $db_driver,
        ?string $mysql_db_host,
        ?string $mysql_db_name,
        ?string $mysql_db_port,
        ?string $mysql_db_username,
        ?string $mysql_db_password,
        ?string $sqlite_db_name
    ) : DatabaseConnector
    {
        return match ($db_driver) {
            'mysql' => MySqlConnectorFactory::create(
                $mysql_db_host,
                $mysql_db_name,
                $mysql_db_port,
                $mysql_db_username,
                $mysql_db_password
            ),
            'sqlite' => SqliteConnectorFactory::create($sqlite_db_name),
        };
    }
}