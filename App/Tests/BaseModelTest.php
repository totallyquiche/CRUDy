<?php declare(strict_types=1);

namespace App\Tests;

use App\Models\BaseModel;
use App\Database\DatabaseAdapterInterface;
use App\Database\PdoAdapter;
use \ReflectionObject;
use App\Config;
use App\Tests\PerformsSetupInterface;
use App\Tests\PerformsTeardownInterface;

class BaseModelTest extends BaseTest implements PerformsSetupInterface, PerformsTeardownInterface
{
    /**
     * Name of the database table used for these tests.
     *
     * @var string
     */
    private string $table_name;

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

        $this->database_adapter->execute("CREATE TABLE `$this->table_name`(`name` VARCHAR(10) NOT NULL)");
    }

    /**
     * Drops the database to use for these tests.
     *
     * @return void
     */
    public function teardown() : void
    {
        $this->database_adapter->execute("DROP TABLE `$this->table_name`", false);
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

        $this->database_adapter->execute("INSERT INTO `$mock->table_name` VALUES('test')");

        return $this->database_adapter->query("SELECT * FROM `$mock->table_name`") === $mock->all();
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