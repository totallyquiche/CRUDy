<?php declare(strict_types=1);

namespace App\Tests;

use App\Database\PdoAdapter;
use App\Config;

class PdoAdapterTest extends BaseTest
{
    /**
     * Test that getInstance() returns the same instance of the PdoAdapter.
     *
     * @return bool
     */
    public function test_getInstance_returns_same_instance()
    {
        return PdoAdapter::getInstance() === PdoAdapter::getInstance();
    }

    /**
     * Test that getInstance() returns different instances when different DB info
     * is used.
     *
     * @return bool
     */
    public function test_getInstance_returns_different_instances_with_different_db_info()
    {
        $first_instance = PdoAdapter::getInstance(
            Config::get('DB_HOST'),
            Config::get('DB_NAME'),
            Config::get('DB_USER'),
            Config::get('DB_PASSWORD')
        );

        $second_instance = PdoAdapter::getInstance(
            Config::get('TEST_DB_HOST'),
            Config::get('TEST_DB_NAME'),
            Config::get('TEST_DB_USER'),
            Config::get('TEST_DB_PASSWORD')
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
        $first_instance = PdoAdapter::getInstance(
            Config::get('DB_HOST'),
            Config::get('DB_NAME'),
            Config::get('DB_USER'),
            Config::get('DB_PASSWORD')
        );

        $second_instance = PdoAdapter::getInstance(
            Config::get('TEST_DB_HOST'),
            Config::get('TEST_DB_NAME'),
            Config::get('TEST_DB_USER'),
            Config::get('TEST_DB_PASSWORD')
        );

        $third_instance = PdoAdapter::getInstance();

        return $second_instance === $third_instance;
    }

    /**
     * Test that query() returns the results of a query.
     *
     * @return bool
     */
    public function test_query_returns_query_results()
    {
        $this->database_adapter = PdoAdapter::getInstance(
            Config::get('TEST_DB_HOST'),
            Config::get('TEST_DB_NAME'),
            Config::get('TEST_DB_USER'),
            Config::get('TEST_DB_PASSWORD')
        );

        $table_name = 'pdo_adapter_test_' . str_replace('.', '_', microtime(true));
        $column_name = 'test_name';
        $row_value = 'test value';

        $this->database_adapter->execute("CREATE TABLE `$table_name` (`$column_name` VARCHAR(10) NOT NULL)");
        $this->database_adapter->execute("INSERT INTO `$table_name` (`$column_name`) VALUES ('$row_value')");

        $query_results = $this->database_adapter->query("SELECT * FROM `$table_name`");

        $this->database_adapter->execute("DROP TABLE `$table_name`");

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
        $this->database_adapter = PdoAdapter::getInstance(
            Config::get('TEST_DB_HOST'),
            Config::get('TEST_DB_NAME'),
            Config::get('TEST_DB_USER'),
            Config::get('TEST_DB_PASSWORD')
        );

        $table_name = 'pdo_adapter_test_' . str_replace('.', '_', microtime(true));
        $column_name = 'test_name';

        $this->database_adapter->execute("CREATE TABLE `$table_name` (`$column_name` VARCHAR(10) NOT NULL)");

        $db_tables = $this->database_adapter->query('SHOW TABLES');

        $this->database_adapter->execute("DROP TABLE `$table_name`");

        return
            (count($db_tables) === 1) &&
            (count($db_tables[0]) === 1) &&
            array_shift($db_tables[0]) === $table_name;
    }
}