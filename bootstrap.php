<?php

declare(strict_types=1);

namespace App;

use App\Config\Factories\ConfigFactory;
use App\Database\Connectors\Factories\DatabaseConnectorFactory;
use App\Routers\HttpRouter;
use App\Routers\CliRouter;
use App\View\Renderers\TemplateRenderer;
use App\View\Renderers\DirectRenderer;

require_once(__DIR__ . '/autoload.php');

$config = ConfigFactory::create(file(__DIR__ . '/.env'));
$db_driver = $config->get('DB_DRIVER');

if ($db_driver) {
    $database_connector = DatabaseConnectorFactory::create(
        $db_driver,
        $config->get('MYSQL_DB_HOST'),
        $config->get('MYSQL_DB_NAME'),
        $config->get('MYSQL_DB_PORT'),
        $config->get('MYSQL_DB_USERNAME'),
        $config->get('MYSQL_DB_PASSWORD'),
        $config->get('SQLITE_DB_NAME')
    );
}

if (isset($_SERVER['REQUEST_URI'])) {
    require_once(__DIR__ . '/App/Http/routes.php');

    $template_renderer = new TemplateRenderer(
        $config->get('SITE_TITLE'),
        $config->get('SITE_URL'),
        intval($config->get('VIEW_CACHE_SECONDS_TO_EXPIRY'))
    );

    $router = new HttpRouter(
        $routes,
        $_SERVER['REQUEST_URI'],
        $template_renderer
    );
} else {
    require_once(__DIR__ . '/App/Cli/routes.php');

    $cli_renderer = new DirectRenderer;

    $router = new CliRouter(
        $routes,
        $argv[1] ?? '',
        $cli_renderer,
        $argv
    );
}

App::init(
    $config,
    $router,
    $database_connector ?? null
);