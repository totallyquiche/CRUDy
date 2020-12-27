<?php declare(strict_types=1);

namespace App\Tests;

use App\Models\BaseModel;
use App\Database\DatabaseAdapterInterface;
use App\Database\PdoAdapter;
use \ReflectionObject;
use App\Config;

class BaseModelTest extends BaseTest
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
     * @var DatabaseAdapterInterface
     */
    private DatabaseAdapterInterface $database_adapter;

    /**
     * Creates a database to use for these tests.
     *
     * @return void
     */
    public function setup() : void
    {
        $this->table_name = 'base_model' . '_' . str_replace('.', '_', microtime(true));

        $this->database_adapter = new PdoAdapter(
            Config::get('TEST_DB_HOST'),
            Config::get('TEST_DB_NAME'),
            Config::get('TEST_DB_USER'),
            Config::get('TEST_DB_PASSWORD')
        );

        $this->createTable($this->database_adapter);
        $this->seedTable($this->database_adapter);
    }

    /**
     * Drops the database to use for these tests.
     *
     * @return void
     */
    public function teardown() : void
    {
        $this->dropTable($this->database_adapter);
    }

    /**
     * Test constructor sets the database adapter.
     *
     * @return bool
     */
    public function test_constructor_set_database_adapter() : bool
    {
        $pdo_adapter = $this->database_adapter;

        $mock = $this->getBaseModelMock($this->database_adapter);

        $reflection = new ReflectionObject($mock);
        $database_adapter_interface_property = $reflection->getProperty('database_adapter_interface');
        $database_adapter_interface_property->setAccessible(true);
        $database_adapter = $database_adapter_interface_property->getValue($mock);

        return $pdo_adapter === $database_adapter;
    }

    /**
     * Test all method returns all records from the database.
     *
     * @return bool
     */
    public function test_all_returns_all_records() : bool
    {
        $mock = $this->getBaseModelMock($this->database_adapter);

        return $this->database_adapter->query("SELECT * FROM `$mock->table_name`") === $mock->all();
    }

    /**
     * Test find method returns the matching record form the database.
     *
     * @return bool
     */
    public function test_find_returns_expected_record() : bool
    {
        $mock = $this->getBaseModelMock($this->database_adapter);

        $expected_results = $this->database_adapter->query(
            "SELECT * FROM `$mock->table_name` WHERE `id` = 2"
        );

        return $expected_results === $mock->find(2);
    }

    /**
     * Get a mock of BaseModel.
     *
     * @param DatabaseAdapterInterface $database_adapter_interface
     *
     * @return BaseModel
     */
    private function getBaseModelMock(DatabaseAdapterInterface $database_adapter_interface) : BaseModel
    {
        $class_name = 'BaseModelMock_' . str_replace('.', '_', microtime(true));

        $mock_class = <<<CLASS
            namespace App\Models;

            class {$class_name} extends BaseModel
            {
                public string \$table_name = '{$this->table_name}';
            }
        CLASS;

        eval($mock_class);

        $fully_qualified_class_name = 'App\\Models\\' . $class_name;

        return new $fully_qualified_class_name($database_adapter_interface);
    }

    /**
     * Drop the database table.
     *
     * @pararm DatabaseAdapterInterface $database_adapter
     *
     * @return void
     */
    private function dropTable(DatabaseAdapterInterface $database_adapter) : void
    {
        $this->database_adapter->execute(
            "DROP TABLE `$this->table_name`",
            false
        );
    }

    /**
     * Create the database table.
     *
     * @param DatabaseAdapterInterface $database_adapter
     *
     * @return void
     */
    private function createTable(DatabaseAdapterInterface $database_adapter) : void
    {
        $this->database_adapter->execute(
            "CREATE TABLE `$this->table_name`(`$this->primary_key` INT(11) AUTO_INCREMENT PRIMARY KEY, `name` VARCHAR(10) NOT NULL)"
        );
    }

    /**
     * Seed the database table.
     *
     * @param DatabaseAdapterInterface $database_adapter
     *
     * @return void
     */
    private function seedTable(DatabaseAdapterInterface $database_adapter) : void
    {
        $database_adapter->execute("INSERT INTO `$this->table_name` VALUES(null, 'test1')");
        $database_adapter->execute("INSERT INTO `$this->table_name` VALUES(null, 'test2')");
        $database_adapter->execute("INSERT INTO `$this->table_name` VALUES(null, 'test3')");
        $database_adapter->execute("INSERT INTO `$this->table_name` VALUES(null, 'test4')");
        $database_adapter->execute("INSERT INTO `$this->table_name` VALUES(null, 'test5')");
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