<?php

declare(strict_types=1);

namespace App\Tests;

use App\Database\Connectors\SqliteConnector;
use App\Database\Configs\SqliteConnectorConfig;
use App\Config;

final class SqliteConnectorTest extends BaseTest
{
    /**
     * Run the tests, performing setup and teardown steps.
     *
     * @return void
     */
    public function run() : string
    {
        $results = parent::run();

        $this->teardown();

        return $results;
    }

    /**
     * Delete databases files after tests run.
     *
     * @return void
     */
    private function teardown() : void
    {
        $db_files = [
            Config::get('SQLITE_FILE_NAME'),
            Config::get('SQLITE_TEST_FILE_NAME'),
        ];

        foreach ($db_files as $db_file) {
            if (file_exists($db_file)) {
                unlink($db_file);
            }
        }
    }

    /**
     * Test that getInstance() returns the same instance of the SqliteConnector.
     *
     * @return bool
     */
    public function test_getInstance_returns_same_instance()
    {
        return SqliteConnector::getInstance() === SqliteConnector::getInstance();
    }

    /**
     * Test that getInstance() returns different instances when different DB info
     * is used.
     *
     * @return bool
     */
    public function test_getInstance_returns_different_instances_with_different_db_info()
    {
        $sqlite_connector_config = new SqliteConnectorConfig();
        $sqlite_connector_config->name = Config::get('SQLITE_FILE_NAME');
        $first_instance = SqliteConnector::getInstance($sqlite_connector_config);

        $sqlite_connector_config = new SqliteConnectorConfig();
        $sqlite_connector_config->name = Config::get('SQLITE_TEST_FILE_NAME');
        $second_instance = SqliteConnector::getInstance($sqlite_connector_config);

        return $first_instance !== $second_instance;
    }

    /**
     * Test that, after creating a new instance by passing in new DB info, getInstance()
     * returns the same instance.
     *
     * @return bool
     */
    public function test_getInstance_returns_same_instance_after_creating_a_new_instance()
    {
        // Generate an initial instance
        SqliteConnector::getInstance();

        $sqlite_connector_config = new SqliteConnectorConfig();
        $sqlite_connector_config->name = Config::get('SQLITE_TEST_FILE_NAME');
        $second_instance = SqliteConnector::getInstance($sqlite_connector_config);

        $third_instance = SqliteConnector::getInstance();

        return $second_instance === $third_instance;
    }

    /**
     * Test that query() returns the results of a query.
     *
     * @return bool
     */
    public function test_query_returns_query_results()
    {
        $sqlite_connector_config = new SqliteConnectorConfig();
        $sqlite_connector_config->name = Config::get('SQLITE_TEST_FILE_NAME');
        $sqlite_connector = SqliteConnector::getInstance($sqlite_connector_config);

        $table_name = 'pdo_adapter_test_' . str_replace('.', '_', (string) microtime(true));
        $column_name = 'test_name';
        $row_value = 'test value';

        $sqlite_connector->execute("CREATE TABLE `$table_name` (`$column_name` VARCHAR(10) NOT NULL)");
        $sqlite_connector->execute("INSERT INTO `$table_name` (`$column_name`) VALUES ('$row_value')");

        $query_results = $sqlite_connector->query("SELECT * FROM `$table_name`");

        $sqlite_connector->execute("DROP TABLE `$table_name`");

        return
            (count($query_results) === 1) &&
            isset($query_results[0][$column_name]) &&
            ($query_results[0][$column_name] === $row_value);
    }

    /**
     * Test that execute() executes a query.
     *
     * @return bool
     */
    public function test_execute_executes_query()
    {
        $sqlite_connector_config = new SqliteConnectorConfig();
        $sqlite_connector_config->name = Config::get('SQLITE_TEST_FILE_NAME');
        $sqlite_connector = SqliteConnector::getInstance($sqlite_connector_config);

        $table_name = 'pdo_adapter_test_' . str_replace('.', '_', (string) microtime(true));
        $column_name = 'test_name';

        $sqlite_connector->execute("CREATE TABLE `$table_name` (`$column_name` VARCHAR(10) NOT NULL)");

        $db_tables = $sqlite_connector->query("SELECT `name` FROM `sqlite_master` WHERE `name` = '$table_name'");

        $sqlite_connector->execute("DROP TABLE `$table_name`");

        return
            (count($db_tables) === 1) &&
            isset($db_tables[0]['name']) &&
            ($db_tables[0]['name'] === $table_name);
    }
}