<?php

declare(strict_types=1);

namespace App\Tests;

use App\Config\Config;
use App\Database\Connectors\DatabaseConnector;
use App\Tests\Attributes\DataProvider;
use \ReflectionClass;

abstract class Test
{
    /**
     * Handle instantiation.
     *
     * @param Config            $config
     * @param null|DatabaseConnector $database_connector
     *
     * @return void
     */
    public function __construct(
        protected Config $config,
        protected ?DatabaseConnector $database_connector
    ) {}

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