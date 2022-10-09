<?php

declare(strict_types=1);

namespace App\Tests;

use App\Config;
use App\Database\Connectors\DatabaseConnector;
use App\Tests\Test;
use App\Tests\Factories\TestFactory;

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
        $all_results = [];

        foreach ($test_classes as $test_class) {
            if (class_exists($test_class) && $test_class !== Test::class) {
                $results = (TestFactory::create(
                    $test_class,
                    $this->config,
                    $this->database_connector
                ))->run();

                foreach ($results as $result) {
                    $all_results[] = $result;
                }
            }
        }

        echo $this->generateResultsMessage($all_results);
    }

    /**
     * Generate a message based on the test results.
     *
     * @param array $results
     *
     * @return string
     */
    private function generateResultsMessage(array $results) : string
    {
        $red_color_code = "\e[31m";
        $green_color_code = "\e[32m";
        $end_color_code = "\e[0m";
        $bold_code = "\033[1m";
        $end_bold_code = "\033[0m";
        $passed_count = 0;
        $failed_count = 0;
        $message = '';

        foreach ($results as $result) {
            if ($result['result']) {
                $passed_count++;
                $message .= $green_color_code . 'Passed ' . $end_color_code;
                $message .= $result['class'];
            } else {
                $failed_count++;
                $message .= $red_color_code . 'Failed ' . $end_color_code;
                $message .= $result['class'];
            }

            if (isset($result['method'])) {
                $message .= '::' . $result['method'] . '()';
            }

            if (isset($result['case'])) {
                $message .= ' | Case: ' . $result['case'];
            }

            $message .= PHP_EOL;
        }

        $message .= PHP_EOL . $bold_code;
        $message .= 'Passed: ' . $passed_count . ', Failed: ' . $failed_count;
        $message .= $end_bold_code;

        return PHP_EOL . $message . PHP_EOL . PHP_EOL;
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