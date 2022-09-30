<?php declare(strict_types=1);

namespace App\Tests;

use App\Database\MySqlConnector;
use App\Config;

final class MySqlConnectorTest extends BaseTest
{
    /**
     * Test that getInstance() returns the same instance of the MySqlConnector.
     *
     * @return bool
     */
    public function test_getInstance_returns_same_instance()
    {
        return MySqlConnector::getInstance() === MySqlConnector::getInstance();
    }

    /**
     * Test that getInstance() returns different instances when different DB info
     * is used.
     *
     * @return bool
     */
    public function test_getInstance_returns_different_instances_with_different_db_info()
    {
        $first_instance = MySqlConnector::getInstance();

        $second_instance = MySqlConnector::getInstance(
            Config::get('MYSQL_TEST_DB_HOST'),
            Config::get('MYSQL_TEST_DB_NAME'),
            Config::get('MYSQL_TEST_DB_USER'),
            Config::get('MYSQL_TEST_DB_PASSWORD'),
            Config::get('MYSQL_TEST_DB_PORT')
        );

        return $first_instance != $second_instance;
    }

    /**
     * Test that, after creating a new instance by passing in new DB info, getInstance()
     * returns the same instance.
     *
     * @return bool
     */
    public function test_getInstance_returns_same_instance_after_creating_a_new_instance()
    {
        $first_instance = MySqlConnector::getInstance();

        $second_instance = MySqlConnector::getInstance(
            Config::get('MYSQL_TEST_DB_HOST'),
            Config::get('MYSQL_TEST_DB_NAME'),
            Config::get('MYSQL_TEST_DB_USER'),
            Config::get('MYSQL_TEST_DB_PASSWORD'),
            Config::get('MYSQL_TEST_DB_PORT')
        );

        $third_instance = MySqlConnector::getInstance();

        return $second_instance === $third_instance;
    }

    /**
     * Test that query() returns the results of a query.
     *
     * @return bool
     */
    public function test_query_returns_query_results()
    {
        $this->database_connector = MySqlConnector::getInstance(
            Config::get('MYSQL_TEST_DB_HOST'),
            Config::get('MYSQL_TEST_DB_NAME'),
            Config::get('MYSQL_TEST_DB_USER'),
            Config::get('MYSQL_TEST_DB_PASSWORD'),
            Config::get('MYSQL_TEST_DB_PORT')
        );

        $table_name = 'pdo_adapter_test_' . str_replace('.', '_', (string) microtime(true));
        $column_name = 'test_name';
        $row_value = 'test value';

        $this->database_connector->execute("CREATE TABLE `$table_name` (`$column_name` VARCHAR(10) NOT NULL)");
        $this->database_connector->execute("INSERT INTO `$table_name` (`$column_name`) VALUES ('$row_value')");

        $query_results = $this->database_connector->query("SELECT * FROM `$table_name`");

        $this->database_connector->execute("DROP TABLE `$table_name`");

        return
            (count($query_results) === 1) &&
            (count($query_results[0]) === 1) &&
            isset($query_results[0][$column_name]) &&
            $query_results[0][$column_name] === $row_value;
    }

    /**
     * Test that execute() executes a query.
     *
     * @return bool
     */
    public function test_execute_executes_query()
    {
        $this->database_connector = MySqlConnector::getInstance(
            Config::get('MYSQL_TEST_DB_HOST'),
            Config::get('MYSQL_TEST_DB_NAME'),
            Config::get('MYSQL_TEST_DB_USER'),
            Config::get('MYSQL_TEST_DB_PASSWORD'),
            Config::get('MYSQL_TEST_DB_PORT')
        );

        $table_name = 'pdo_adapter_test_' . str_replace('.', '_', (string) microtime(true));
        $column_name = 'test_name';

        $this->database_connector->execute("CREATE TABLE `$table_name` (`$column_name` VARCHAR(10) NOT NULL)");

        $db_tables = $this->database_connector->query('SHOW TABLES');

        $this->database_connector->execute("DROP TABLE `$table_name`");

        return
            (count($db_tables) === 1) &&
            (count($db_tables[0]) === 1) &&
            array_shift($db_tables[0]) === $table_name;
    }
}