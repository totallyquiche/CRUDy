<?php declare(strict_types=1);

namespace App\Tests;

use App\Tests\BaseTest;

class TestRunner
{
    /**
    /**
     * Run all tests.
     *
     * @return void
     */
    public function run() : void
    {
        foreach ($this->getTestClasses() as $test_class) {
            if (class_exists($test_class) && $test_class !== BaseTest::class) {
                $test_class = new $test_class;

                $test_class->setup();

                echo $test_class->run();

                $test_class->teardown();
            }
        }
    }

    /**
     * Get test class names from Tests directory.
     *
     * @return array
     */
    private function getTestClasses() : array
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