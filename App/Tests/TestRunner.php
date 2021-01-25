<?php declare(strict_types=1);

namespace App\Tests;

use App\Tests\BaseTest;

class TestRunner
{
    /**
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
                $test_class = new $test_class;

                echo $test_class->run();
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