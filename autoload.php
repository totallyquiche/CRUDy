<?php

declare(strict_types=1);

namespace App;

spl_autoload_register(function ($class_name) {
    $file_path = __DIR__ . '/' . str_replace('\\', '/', $class_name) . '.php';

    if (file_exists($file_path)) {
        require($file_path);

        return true;
    }

    return false;
});