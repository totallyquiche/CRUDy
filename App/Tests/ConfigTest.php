<?php

declare(strict_types=1);

namespace App\Tests;

use App\Tests\Attributes\DataProvider;
use App\Config;

final class ConfigTest extends Test
{
    /**
     * Data Provider for config file lines. The data consists of key/value pairs
     * matching lines in a environment variable config file. For example,
     * OPTION=VALUE would be represented by ['OPTION' => 'VALUE'].
     *
     * @return array
     */
    public function provideConfigFileLines() : array
    {
        return [
            'A single config line' => [
                'data' => ['a' => 'b'],
                'expected_results' => ['a' => 'b'],
            ],
            'Multiple config lines' => [
                'data' => [
                    'a' => 'b',
                    'y' => 'z',
                ],
                'expected_results' => [
                    'a' => 'b',
                    'y' => 'z',
                ],
            ],
            'No lines' => [
                'data' => [],
                'expected_results' => [],
            ],
            'Null values result in an empty string' => [
                'data' => ['a' => null],
                'expected_results' => ['a' => ''],
            ],
            'Mixed data types convert to strings' => [
                'data' => [
                    'a' => null,
                    'b' => 'c',
                    'd' => 1,
                    'e' => 0.9,
                ],
                'expected_results' => [
                    'a' => '',
                    'b' => 'c',
                    'd' => '1',
                    'e' => '0.9',
                ],
            ],
            'Missing values result in empty strings' => [
                'data' => ['a' => ''],
                'expected_results' => ['a' => '']
            ]
        ];
    }

    /**
     * Test setConfigOptions() method.
     *
     * @param array $test_data
     * @param array $expected_results
     *
     * @return bool
     */
    #[DataProvider('provideConfigFileLines')]
    public function test_can_set_and_retrieve_config_options(
        array $test_data,
        array $expected_results
    ) : bool
    {
        $lines = [];

        foreach ($test_data as $key => $value) {
            $lines[] = $key . '=' . $value;
        }

        $config = new Config;
        $config->setConfigOptions($lines);

        $results = [];

        foreach ($test_data as $key => $value) {
            $results[$key] = $config->get($key);
        }

        return $results === $expected_results;
    }
}