<?php

declare(strict_types=1);

namespace App\Database\Configs;

final class MySqlConnectorConfig extends DatabaseConnectorConfig {
    /**
     * @var string
     */
    public string $host;

    /**
     * @var string
     */
    public string $name;

    /**
     * @var string
     */
    public string $user;

    /**
     * @var string
     */
    public string $password;

    /**
     * @var int
     */
    public string $port;
}