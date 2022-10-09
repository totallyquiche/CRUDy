<?php

declare(strict_types=1);

namespace App\Tests;

use App\Config;
use App\Database\Connectors\DatabaseConnector;
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
        $failed_tests = [];

        foreach ((new ReflectionClass(static::class))->getMethods() as $method) {
            if (str_starts_with($method->name, 'test_')) {
                if (!$this->{$method->name}()) {
                    $failed_tests[] = $method->name;
                }
            }
        }

        if (empty($failed_tests)) {
            return static::class . ': Passed' . PHP_EOL;
        } else {
            return static::class . ': Failed' . PHP_EOL . implode(PHP_EOL, $failed_tests) . PHP_EOL;
        }
    }
}