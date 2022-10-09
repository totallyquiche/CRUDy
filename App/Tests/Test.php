<?php

declare(strict_types=1);

namespace App\Tests;

use App\Config;
use App\Database\Connectors\DatabaseConnector;
use App\Tests\Attributes\DataProvider;
use \ReflectionClass;

abstract class Test
{
    /**
     * @var Config
     */
    protected Config $config;

    /**
     * @var DatabaseConnector
     */
    protected DatabaseConnector $database_connector;

    /**
     * Handle instantiation.
     *
     * @param Config            $config
     * @param DatabaseConnector $database_connector
     *
     * @return void
     */
    public function __construct(Config $config, DatabaseConnector $database_connector) {
        $this->config = $config;
        $this->database_connector = $database_connector;
    }

    /**
     * Call test methods and return the results as a string.
     *
     * @return string
     */
    public function run() : string
    {
        $red_color_code = "\e[31m";
        $green_color_code = "\e[32m";
        $end_color_code = "\e[0m";

        $failed_tests = [];

        foreach ((new ReflectionClass(static::class))->getMethods() as $method) {
            if (str_starts_with($method->name, 'test_')) {
                $data_provider_attributes = $method->getAttributes(DataProvider::class);

                if (empty($data_provider_attributes)) {
                    if (!$this->{$method->name}()) {
                        $failed_tests[] = ['test_method' => $method->name];
                    }
                } else {
                    foreach ($data_provider_attributes as $data_provider_attribute) {
                        $tests_data = $this->{$data_provider_attribute->newInstance()->method_name}();

                        foreach ($tests_data as $test_case => $test_data) {
                            if (!$this->{$method->name}($test_data)) {
                                $failed_tests[] = [
                                    'case' => $test_case,
                                    'method' => $method->name,
                                ];
                            }
                        }
                    }
                }
            }
        }

        if (empty($failed_tests)) {
            $message = $green_color_code . 'Passed ' . $end_color_code;
            $message .= static::class . PHP_EOL;
        } else {
            $message = $red_color_code . 'Failed ' . $end_color_code;
            $message .= static::class . PHP_EOL;

            foreach ($failed_tests as $failed_test) {
                $message .= '       - ' . $failed_test['method'] . '()';

                if (isset($failed_test['case'])) {
                    $message .= ': ' . $failed_test['case'];
                }

                $message .= PHP_EOL;
            }
        }

        return $message;
    }
}