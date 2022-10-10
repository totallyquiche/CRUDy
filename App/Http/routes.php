<?php

declare(strict_types=1);

namespace App\Http;

use App\Http\Controllers\HomeController;

$routes = [
    '/' => [HomeController::class, 'index'],
];