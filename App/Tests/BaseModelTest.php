<?php declare(strict_types=1);

namespace App\Tests;

use App\Models\BaseModel;
use App\Database\DatabaseConnectorInterface;
use App\Database\PdoConnector;
use \ReflectionObject;
use App\Config;

final class BaseModelTest extends BaseTest
{
    /**
     * Name of the database table used for these tests.
     *
     * @var string
     */
    private string $table_name;

    /**
     * Name of the database table primary key used for these tests.
     *
     * @var string
     */
    private string $primary_key = 'id';

    /**
     * Database connector for these tests.
     *
     * @var DatabaseConnectorInterface
     */
    private DatabaseConnectorInterface $database_connector;

    /**
     * Creates a database to use for these tests.
     *
     * @return void
     */
    public function setup() : void
    {
        $this->table_name = 'base_model' . '_' . str_replace('.', '_', (string) microtime(true));

        $this->database_connector = PdoConnector::getInstance(
            Config::get('TEST_DB_HOST'),
            Config::get('TEST_DB_NAME'),
            Config::get('TEST_DB_USER'),
            Config::get('TEST_DB_PASSWORD')
        );

        $this->createTable($this->database_connector);
        $this->seedTable($this->database_connector);
    }

    /**
     * Drops the database to use for these tests.
     *
     * @return void
     */
    public function teardown() : void
    {
        $this->dropTable($this->database_connector);
    }

    /**
     * Test constructor sets the database adapter.
     *
     * @return bool
     */
    public function test_constructor_set_database_connector() : bool
    {
        $pdo_adapter = $this->database_connector;

        $mock = $this->getBaseModelMock($this->database_connector);

        $reflection = new ReflectionObject($mock);
        $database_connector_property = $reflection->getProperty('database_connector');
        $database_connector_property->setAccessible(true);
        $database_connector = $database_connector_property->getValue($mock);

        return $pdo_adapter === $database_connector;
    }

    /**
     * Test all method returns all records from the database.
     *
     * @return bool
     */
    public function test_all_returns_all_records() : bool
    {
        $mock = $this->getBaseModelMock($this->database_connector);

        return $this->database_connector->query("SELECT * FROM `$mock->table_name`") === $mock->all();
    }

    /**
     * Test find method returns the matching record form the database.
     *
     * @return bool
     */
    public function test_find_returns_expected_record() : bool
    {
        $mock = $this->getBaseModelMock($this->database_connector);

        $expected_results = $this->database_connector->query(
            "SELECT * FROM `$mock->table_name` WHERE `id` = 2"
        );

        return $expected_results === $mock->find(2);
    }

    /**
     * Get a mock of BaseModel.
     *
     * @param DatabaseConnectorInterface $database_connector
     *
     * @return BaseModel
     */
    private function getBaseModelMock(DatabaseConnectorInterface $database_connector) : BaseModel
    {
        $class_name = 'BaseModelMock_' . str_replace('.', '_', (string) microtime(true));

        $mock_class = <<<CLASS
            namespace App\Models;

            class {$class_name} extends BaseModel
            {
                public string \$table_name = '{$this->table_name}';
            }
        CLASS;

        eval($mock_class);

        $fully_qualified_class_name = 'App\\Models\\' . $class_name;

        return new $fully_qualified_class_name($database_connector);
    }

    /**
     * Drop the database table.
     *
     * @pararm DatabaseConnectorInterface $database_connector
     *
     * @return void
     */
    private function dropTable(DatabaseConnectorInterface $database_connector) : void
    {
        $this->database_connector->execute(
            "DROP TABLE `$this->table_name`",
            false
        );
    }

    /**
     * Create the database table.
     *
     * @param DatabaseConnectorInterface $database_connector
     *
     * @return void
     */
    private function createTable(DatabaseConnectorInterface $database_connector) : void
    {
        $this->database_connector->execute(
            "CREATE TABLE `$this->table_name`(`$this->primary_key` INT(11) AUTO_INCREMENT PRIMARY KEY, `name` VARCHAR(10) NOT NULL)"
        );
    }

    /**
     * Seed the database table.
     *
     * @param DatabaseConnectorInterface $database_connector
     *
     * @return void
     */
    private function seedTable(DatabaseConnectorInterface $database_connector) : void
    {
        $database_connector->execute("INSERT INTO `$this->table_name` VALUES(null, 'test1')");
        $database_connector->execute("INSERT INTO `$this->table_name` VALUES(null, 'test2')");
        $database_connector->execute("INSERT INTO `$this->table_name` VALUES(null, 'test3')");
        $database_connector->execute("INSERT INTO `$this->table_name` VALUES(null, 'test4')");
        $database_connector->execute("INSERT INTO `$this->table_name` VALUES(null, 'test5')");
    }

    /**
     * Run the tests, performing setup and teardown steps.
     *
     * @return void
     */
    public function run() : string
    {
        $this->setup();

        $results = parent::run();

        $this->teardown();

        return $results;
    }
}