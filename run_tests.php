<?php

declare(strict_types=1);

namespace App;

use App\Tests\TestRunner;

$config_file_path = __DIR__ . '/.env.test';

require_once(__DIR__ . '/bootstrap.php');

isset($argv[1]) ? $tests = [$argv[1]] : $tests = TestRunner::getAllTestClasses();

(new TestRunner(
    $config,
    $database_connector
))->run($tests);