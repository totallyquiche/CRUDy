<?php

declare(strict_types=1);

namespace App\Database\Configs;

abstract class DatabaseConnectorConfig {
    /**
     * Fetch a config value.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function get(string $key) : mixed
    {
        return $this->{$key};
    }
}