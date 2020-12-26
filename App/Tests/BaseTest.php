<?php declare(strict_types=1);

namespace App\Tests;

use \ReflectionClass;

abstract class BaseTest
{
    /**
     * Call test methods and return the results as a string.
     *
     * @return string
     */
    public function run() : string
    {
        $failed_tests = [];

        foreach ((new ReflectionClass(static::class))->getMethods() as $method) {
            if (strpos($method->name, 'test_') === 0) {
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