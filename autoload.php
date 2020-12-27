<?php declare(strict_types=1);

spl_autoload_register(function ($class_name) {
    $file_path = str_replace('\\', '/', $class_name) . '.php';

    if (file_exists($file_path)) {
        require($file_path);

        return true;
    }

    return false;
});