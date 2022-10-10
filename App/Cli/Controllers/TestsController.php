<?php

declare(strict_types=1);

namespace App\Cli\Controllers;

use App\App;
use App\Tests\TestRunner;

final class TestsController extends CliController
{
    /**
     * Display the version of the application.
     *
     * @return string
     */
    public function run() : string
    {
        $test_runner = new TestRunner(
                App::getConfig(),
                App::getDatabaseConnector()
        );

        $tests = [];

        if (count($this->args) > 2) {
            foreach (array_slice($this->args, 2) as $test) {
                $tests[] = $test;
            }
        } else {
            $tests = TestRunner::getAllTestClasses();
        }

        $this->view_renderer->setContent(
            $test_runner->run($tests)
        );

        return $this->view_renderer->renderView();
    }
}