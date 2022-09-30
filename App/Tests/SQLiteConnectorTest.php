<?php declare(strict_types=1);

namespace App\Tests;

use App\Database\Connectors\SQLiteConnector;
use App\Database\Configs\SQLiteConnectorConfig;
use App\Config;

final class SQLiteConnectorTest extends BaseTest
{
    /**
     * Test that getInstance() returns the same instance of the SQLiteConnector.
     *
     * @return bool
     */
    public function test_getInstance_returns_same_instance()
    {
        return SQLiteConnector::getInstance() === SQLiteConnector::getInstance();
    }

    /**
     * Test that getInstance() returns different instances when different DB info
     * is used.
     *
     * @return bool
     */
    public function test_getInstance_returns_different_instances_with_different_db_info()
    {
        $sqlite_connector_config = new SQLiteConnectorConfig();
        $sqlite_connector_config->name = Config::get('SQLITE_DB_NAME');
        $first_instance = SQLiteConnector::getInstance($sqlite_connector_config);

        $sqlite_connector_config = new SQLiteConnectorConfig();
        $sqlite_connector_config->name = Config::get('SQLITE_TEST_DB_NAME');
        $second_instance = SQLiteConnector::getInstance($sqlite_connector_config);

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
        SQLiteConnector::getInstance();

        $sqlite_connector_config = new SQLiteConnectorConfig();
        $sqlite_connector_config->name = Config::get('SQLITE_TEST_DB_NAME');
        $second_instance = SQLiteConnector::getInstance($sqlite_connector_config);

        $third_instance = SQLiteConnector::getInstance();

        return $second_instance === $third_instance;
    }

    /**
     * Test that query() returns the results of a query.
     *
     * @return bool
     */
    public function test_query_returns_query_results()
    {
        $sqlite_connector_config = new SQLiteConnectorConfig();
        $sqlite_connector_config->name = Config::get('SQLITE_TEST_DB_NAME');
        $sqlite_connector = SQLiteConnector::getInstance($sqlite_connector_config);

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
        $sqlite_connector_config = new SQLiteConnectorConfig();
        $sqlite_connector_config->name = Config::get('SQLITE_TEST_DB_NAME');
        $sqlite_connector = SQLiteConnector::getInstance($sqlite_connector_config);

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