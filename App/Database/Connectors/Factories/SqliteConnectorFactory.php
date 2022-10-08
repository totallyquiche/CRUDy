<?php

declare(strict_types=1);

namespace App\Database\Connectors\Factories;

use App\Database\Connectors\SqliteConnector;
use App\Database\Factories\PdoFactory;

final class SqliteConnectorFactory
{
    /**
     * Create an instance of SqliteConnector.
     *
     * @param string $db_name
     *
     * @return SqliteConnector
     */
    public static function create(
        string $db_name,
        ) : SqliteConnector
    {
        $pdo = PdoFactory::create(
            sprintf(
                'sqlite:%s',
                $db_name,
            ),
            null,
            null
        );

        return new SqliteConnector($pdo);
    }
}