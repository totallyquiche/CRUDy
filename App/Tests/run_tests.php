<?php

declare(strict_types=1);

namespace App\Tests;

require_once(__DIR__ . '/../../bootstrap.php');

isset($argv[1]) ? $tests = [$argv[1]] : $tests = TestRunner::getAllTestClasses();

(new TestRunner)->run($tests);