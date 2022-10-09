<?php

declare(strict_types=1);

namespace App\Factories;

use App\Config;

final class ConfigFactory
{
    /**
     * Create an instance of Config.
     *
     * @param array $config_file_lines
     *
     * @return Config
     */
    public static function create(array $config_file_lines) : Config
    {
        $config = new Config;
        $config->setConfigOptions($config_file_lines);

        return $config;
    }
}