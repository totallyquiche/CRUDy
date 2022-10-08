<?php

declare(strict_types=1);

namespace App\Database\Connectors\Factories;

use App\Database\Connectors\MySqlConnector;
use App\Database\Factories\PdoFactory;

final class MySqlConnectorFactory
{
    /**
     * Create an instance of MySqlConnector.
     *
     * @param string $host
     * @param string $db_name
     * @param string $port
     * @param string $username
     * @param string $password
     *
     * @return MySqlConnector
     */
    public static function create(
        string $host,
        string $db_name,
        string $port,
        string $username,
        string $password) : MySqlConnector
    {
        $pdo = PdoFactory::create(
            sprintf(
                'mysql:host=%s;dbname=%s;port=%s;',
                $host,
                $db_name,
                $port,
            ),
            $username,
            $password
        );

        return new MySqlConnector($pdo);
    }
}