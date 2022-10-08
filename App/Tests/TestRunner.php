<?php

declare(strict_types=1);

namespace App\Tests;

use App\Config;
use App\Database\Connectors\DatabaseConnector;
use App\Tests\BaseTest;
use App\Tests\Factories\BaseTestFactory;

final class TestRunner
{
    /**
     * Handle instantiation.
     *
     * @param DatabaseConnector $database_connector
     *
     * @return void
     */
    public function __construct(
        private Config $config,
        private DatabaseConnector $database_connector
    ) {}

    /**
     * Run all tests.
     *
     * @param array $test_classes
     *
     * @return void
     */
    public function run(array $test_classes) : void
    {
        foreach ($test_classes as $test_class) {
            if (class_exists($test_class) && $test_class !== BaseTest::class) {
                echo (BaseTestFactory::create(
                    $test_class,
                    $this->config,
                    $this->database_connector
                ))->run();
            }
        }
    }

    /**
     * Get test class names from Tests directory.
     *
     * @return array
     */
    public static function getAllTestClasses() : array
    {
        $test_classes = [];

        foreach (scandir(__DIR__) as $file_name) {
            if ($test_extension_index = strpos($file_name, 'Test.php')) {
                $test_classes[] = 'App\\Tests\\' . substr($file_name, 0, ($test_extension_index + 4));
            }
        }

        return $test_classes;
    }
}