<?php

declare(strict_types=1);

namespace App\Config;

final class Config
{
    /**
     * An array of config options/values for the application.
     *
     * @var array
     */
    private array $config_options = [];

    /**
     * Set config options based on provided config file lines.
     *
     * @param array $config_file_lines
     *
     * @return void
     */
    public function setConfigOptions(array $config_file_lines) : void
    {
        foreach ($config_file_lines as $config_file_line) {
            $config_file_line_parts = explode('=', $config_file_line);

            if (count($config_file_line_parts) === 2) {
                list($key, $value) = $config_file_line_parts;

                if (!is_null($key) && !is_null($value)) {
                    $this->config_options[trim($key)] = trim($value);
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