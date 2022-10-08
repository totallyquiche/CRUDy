<?php

declare(strict_types=1);

namespace App;

use App\Factories\ConfigFactory;
use App\Database\Connectors\Factories\DatabaseConnectorFactory;

require_once(__DIR__ . '/autoload.php');

$config = ConfigFactory::create($config_file_path);

$database_connector = DatabaseConnectorFactory::create(
    $config->get('DB_DRIVER'),
    $config->get('MYSQL_DB_HOST'),
    $config->get('MYSQL_DB_NAME'),
    $config->get('MYSQL_DB_PORT'),
    $config->get('MYSQL_DB_USERNAME'),
    $config->get('MYSQL_DB_PASSWORD'),
    $config->get('SQLITE_DB_NAME')
);

(new App(
    $config,
    $database_connector
))->run();