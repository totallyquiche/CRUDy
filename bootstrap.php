<?php

declare(strict_types=1);

namespace App;

use App\Factories\ConfigFactory;
use App\Database\Connectors\Factories\DatabaseConnectorFactory;
use App\Factories\RouterFactory;
use App\Views\Renderers\TemplateRenderer;

require_once(__DIR__ . '/autoload.php');

$config = ConfigFactory::create(file($config_file_path));
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
    require_once(__DIR__ . '/routes.php');

    $template_renderer = new TemplateRenderer(
        $config->get('SITE_TITLE'),
        $config->get('SITE_URL'),
        intval($config->get('VIEW_CACHE_SECONDS_TO_EXPIRY'))
    );

    $router = RouterFactory::create(
        $routes,
        $_SERVER['REQUEST_URI'],
        $template_renderer
    );
}

$app = new App(
    $config,
    $database_connector ?? null,
    $router ?? null
);

echo $app->run();