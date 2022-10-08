<?php

declare(strict_types=1);

namespace App\Tests\Factories;

use App\Config;
use App\Database\Connectors\DatabaseConnector;
use App\Tests\BaseTest;

final class BaseTestFactory
{
    /**
     * Create an instance of the specified test class.
     *
     * @param string            $class_name
     * @param Config            $config
     * @param DatabaseConnector $database_connector
     *
     * @return BaseTest
     */
    public static function create(
        string $class_name,
        Config $config,
        DatabaseConnector $database_connector
    ) : BaseTest
    {
        return new $class_name(
            $config,
            $database_connector
        );
    }
}