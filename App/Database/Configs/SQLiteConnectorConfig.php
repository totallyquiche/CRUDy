<?php

declare(strict_types=1);

namespace App\Database\Configs;

final class SqliteConnectorConfig extends DatabaseConnectorConfig {
    /**
     * @var string
     */
    public string $db_name;

    /**
     * @var bool
     */
    public bool $in_memory;
}