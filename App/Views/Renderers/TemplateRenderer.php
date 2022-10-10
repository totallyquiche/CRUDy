<?php

declare(strict_types=1);

namespace App\Views\Renderers;

final class TemplateRenderer extends ViewRenderer
{
    /**
     * Handle instantiation.
     *
     * @param string $site_title
     * @param string $site_url
     * @param int    $view_cache_seconds_to_expiry
     *
     * @return void
     */
    public function __construct(
        private string $site_title,
        private string $site_url,
        private int $view_cache_seconds_to_expiry
    ) {}

    /**
     * Render the specified view.
     *
     * @param string $view_name
     * @param array  $args
     *
     * @return string
     */
    public function renderView(
        string $view_name = '',
        array $args = []
    ) : string
    {
        $cache_file_path = __DIR__ . '/../../Views/Templates/Cache/' . $view_name . '.cache.php';

        if (
            !is_readable($cache_file_path) ||
            (filemtime($cache_file_path) + $this->view_cache_seconds_to_expiry) <= time()
        ) {
            foreach ($args as $key => $value) {
                $$key = is_callable($value) ? $value() : $value;
            }

            if (!isset($site_title)) {
                $site_title = $this->site_title;
            }

            if (!isset($site_url)) {
                $site_url = $this->site_url;
            }

            $file_path = __DIR__ . '/../../Views/Templates/' . $view_name . '.php';

            $file_contents = file($file_path);
            $first_line = $file_contents[0];

            if (preg_match('/{{ (?<template>[a-zA-Z]+) }}/', $first_line, $matches)) {
                $template_file_path =  __DIR__ . '/../../Views/Templates/' . $matches['template'] . '.php';
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