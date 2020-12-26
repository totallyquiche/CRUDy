<?php declare(strict_types=1);

namespace App\Tests;

use App\Config;
use \ReflectionObject;

class ConfigTest extends BaseTest
{
    /**
     * Tests that the load method correctly loads key/value pairs from file path.
     *
     * @return bool
     */
    public function test_load_correctly_loads_key_value_pairs_from_file() : bool
    {
        $config = new Config;

        // Clear existing config options
        $reflection = new ReflectionObject($config);
        $config_options_property = $reflection->getProperty('config_options');
        $config_options_property->setAccessible(true);
        $config_options = $config_options_property->setValue([]);
        $config_options_property->setAccessible(false);

        $config_options = [
            'DB_NAME' => 'my_db',
            'APP_KEY' => 'abc123',
            'VERSION' => '123',
            ' WHITESPACE' => ' WHITESPACE'
        ];

        $expected_config_file_contents = '';

        foreach ($config_options as $key => $value) {
            $expected_config_file_contents .= $key . '=' . $value . PHP_EOL;
        }

        $file_name = __DIR__ . '/.env.' . microtime(true);
        $file_handler = file_put_contents($file_name, $expected_config_file_contents);

        $config->load($file_name);

        unlink($file_name);

        // Get config options
        $reflection = new ReflectionObject($config);
        $config_options_property = $reflection->getProperty('config_options');
        $config_options_property->setAccessible(true);
        $actual_config_options = $config_options_property->getValue();
        $config_options_property->setAccessible(false);

        $expected_config_options = [];

        foreach ($config_options as $key => $value) {
            $expected_config_options[trim($key)] = trim($value);
        }

        return $expected_config_options === $actual_config_options;
    }
}