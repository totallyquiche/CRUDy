<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Config;

abstract class BaseController
{
    /**
     * Returns the contents of the specified view.
     *
     * @param string     $view_name
     * @param array|null $args
     *
     * @return string
     */
    protected function loadView(string $view_name, array $args = []) : string
    {
        $cache_file_path = __DIR__ . '/../Views/Cache/' . $view_name . '.cache.php';
        $cache_file_mod_time = filemtime($cache_file_path);

        if (
            !is_readable($cache_file_path) ||
            ($cache_file_mod_time + Config::get('VIEW_CACHE_SECONDS_TO_EXPIRY')) <= time()
        ) {
            foreach ($args as $key => $value) {
                $$key = is_callable($value) ? $value() : $value;
            }

            $file_path = __DIR__ . '/../Views/' . $view_name . '.php';

            $file_contents = file($file_path);
            $first_line = $file_contents[0];

            if (preg_match('/{{ (?<template>[a-zA-Z]+) }}/', $first_line, $matches)) {
                $template_file_path =  __DIR__ . '/../Views/Templates/' . $matches['template'] . '.php';
                $template_file_contents = file_get_contents($template_file_path);

                array_shift($file_contents);

                $file_contents = preg_replace('/\s*{{ 💩 }}\s*/', implode('', $file_contents), $template_file_contents);
            }

            file_put_contents($cache_file_path, $file_contents);

            ob_start();

            include($cache_file_path);

            file_put_contents($cache_file_path, ob_get_clean());
        }

        return file_get_contents($cache_file_path);
    }
}