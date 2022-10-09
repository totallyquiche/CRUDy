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
     * @return array
     */
    public function run() : array
    {
        $results = [];

        foreach ((new ReflectionClass(static::class))->getMethods() as $method) {
            if (str_starts_with($method->name, 'test_')) {
                $data_provider_attributes = $method->getAttributes(DataProvider::class);

                if (empty($data_provider_attributes)) {
                    $results[] = [
                        'class' => static::class,
                        'method' => $method->name,
                        'result' => $this->{$method->name}(),
                    ];
                } else {
                    foreach ($data_provider_attributes as $data_provider_attribute) {
                        $tests_data = $this->{$data_provider_attribute->newInstance()->method_name}();

                        foreach ($tests_data as $test_case => $test_data) {
                            $results[] = [
                                'class' => static::class,
                                'case' => $test_case,
                                'method' => $method->name,
                                'result' => $this->{$method->name}(
                                    $test_data['data'],
                                    $test_data['expected_results']
                                ),
                            ];
                        }
                    }
                }
            }
        }

        return $results;
    }
}