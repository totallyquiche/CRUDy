<?php

declare(strict_types=1);

namespace App\Cli;

use App\Cli\Controllers\TestsController;

$routes = [
    'tests:run' => [TestsController::class, 'run'],
];