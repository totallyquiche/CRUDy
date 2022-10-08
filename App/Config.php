<?php

declare(strict_types=1);

namespace App;

final class Config
{
    /**
     * An array of config options/values for the application.
     *
     * @var array
     */
    private array $config_options = [];

    /**
     * Load config options/values from the specified path.
     *
     * @param string $config_file_path
     *
     * @return void
     */
    public function load(string $config_file_path) : void
    {
        if ($config_option_strings = file($config_file_path)) {
            foreach ($config_option_strings as $config_option_string) {
                $config_option_parts = explode('=', $config_option_string);

                if (count($config_option_parts) === 2) {
                    list($key, $value) = $config_option_parts;

                    if (!is_null($key) && !is_null($value)) {
                        $this->config_options[trim($key)] = trim($value);
                    }
                }
            }
        }
    }

    /**
     * Return a config option value.
     *
     * @param string $config_name
     *
     * @return null|string
     */
    public function get(string $config_name) : ?string
    {
        return $this->config_options[$config_name] ?? null;
    }
}