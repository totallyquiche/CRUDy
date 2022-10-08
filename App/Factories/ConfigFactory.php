<?php

declare(strict_types=1);

namespace App\Factories;

use App\Config;

final class ConfigFactory
{
    /**
     * Create an instance of Config.
     *
     * @param string $config_file_path
     *
     * @return Config
     */
    public static function create(string $config_file_path) : Config
    {
        $config = new Config;
        $config->load($config_file_path);

        return $config;
    }
}