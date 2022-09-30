<?php

declare(strict_types=1);

namespace App\Database\Configs;

final class SQLiteConnectorConfig extends DatabaseConnectorConfig {
    /**
     * @var string
     */
    public string $name;
}