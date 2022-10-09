<?php

declare(strict_types=1);

namespace App\Tests;

use App\Tests\Attributes\DataProvider;
use App\Config;

final class ConfigTest extends Test
{
    /**
     * Data Provider for config file lines.
     *
     * @return array
     */
    public function provideConfigFileLines() : array
    {
        return [
            'A single config' => ['a' => 'b'],
            'Multiple lines' => [
                'a' => 'b',
                'y' => 'z',
            ],
        ];
    }

    /**
     * Test setConfigOptions() method.
     *
     * @param array $test_data
     *
     * @return bool
     */
    #[DataProvider('provideConfigFileLines')]
    public function test_can_set_and_retrieve_config_options(array $test_data) : bool
    {
        $lines = [];

        foreach ($test_data as $key => $value) {
            $lines[] = $key . '=' . $value;
        }

        $config = new Config;
        $config->setConfigOptions($lines);

        $passing = true;

        foreach ($test_data as $key => $value) {
            if ($config->get($key) !== $value) {
                $passing = false;
                break;
            }
        }

        return $passing;
    }
}