<?php

declare(strict_types=1);

namespace App;

use App\Factories\ConfigFactory;
use App\Database\Connectors\Factories\DatabaseConnectorFactory;
use App\Factories\RouterFactory;
use App\Views\Renderers\TemplateRenderer;

require_once(__DIR__ . '/autoload.php');

$config = ConfigFactory::create(file($config_file_path));

$database_connector = DatabaseConnectorFactory::create(
    $config->get('DB_DRIVER'),
    $config->get('MYSQL_DB_HOST'),
    $config->get('MYSQL_DB_NAME'),
    $config->get('MYSQL_DB_PORT'),
    $config->get('MYSQL_DB_USERNAME'),
    $config->get('MYSQL_DB_PASSWORD'),
    $config->get('SQLITE_DB_NAME')
);

require_once(__DIR__ . '/routes.php');

$view_renderer = new TemplateRenderer(
    $config->get('SITE_TITLE'),
    $config->get('SITE_URL'),
    intval($config->get('VIEW_CACHE_SECONDS_TO_EXPIRY'))
);

$router = RouterFactory::create(
    $routes,
    $_SERVER['REQUEST_URI'] ?? '',
    $view_renderer
);

$app = new App(
    $config,
    $database_connector,
    $router
);

$app->run();