<?php declare(strict_types=1);

namespace App\Tests;

use App\Config;
use \ReflectionClass;

final class ConfigTest extends BaseTest
{
    /**
     * Tests that the load method correctly loads key/value pairs from file path.
     *
     * @return bool
     */
    public function test_load_correctly_loads_key_value_pairs_from_file() : bool
    {
        $config = new Config;

        $original_config_options = $this->getConfigOptions();

        $this->setConfigOptions([]);

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



        $expected_config_options = [];

        foreach ($config_options as $key => $value) {
            $expected_config_options[trim($key)] = trim($value);
        }

        $actual_config_options = $this->getConfigOptions();

        $this->setConfigOptions($original_config_options);

        return $expected_config_options === $actual_config_options;
    }

    /**
     * Test that the get method returns the expected value.
     *
     * @return bool
     */
    public function test_get_returns_expected_value() : bool
    {
        $config = new Config;

        $original_config_options = $this->getConfigOptions();

        $this->setConfigOptions([]);

        $config_options = [
            'CONFIG_NAME' => 'config_value'
        ];

        $expected_config_file_contents = '';

        foreach ($config_options as $key => $value) {
            $expected_config_file_contents .= $key . '=' . $value . PHP_EOL;
        }

        $file_name = __DIR__ . '/.env.' . microtime(true);
        $file_handler = file_put_contents($file_name, $expected_config_file_contents);

        $config->load($file_name);

        unlink($file_name);

        $expected_config_value = Config::get('CONFIG_NAME');

        $this->setConfigOptions($original_config_options);

        return $expected_config_value == $config_options['CONFIG_NAME'];
    }

    /**
     * Clears the current config options.
     *
     * @return array
     */
    private function getConfigOptions() : array
    {
        $reflection = new ReflectionClass(Config::class);
        $config_options_property = $reflection->getProperty('config_options');
        $config_options_property->setAccessible(true);
        $config_options = $config_options_property->getValue();
        $config_options_property->setAccessible(false);

        return $config_options;
    }

    /**
     * Updates the current config options.
     *
     * @param array $value
     *
     * @return void
     */
    private function setConfigOptions(array $value) : void
    {
        $reflection = new ReflectionClass(Config::class);
        $config_options_property = $reflection->getProperty('config_options');
        $config_options_property->setAccessible(true);
        $config_options = $config_options_property->setValue($value);
        $config_options_property->setAccessible(false);
    }
}