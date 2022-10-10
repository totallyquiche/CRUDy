<?php

declare(strict_types=1);

namespace App\Routes;

use App\Controllers\Http\HomeController;

$routes = [
    '/' => [HomeController::class, 'index'],
];