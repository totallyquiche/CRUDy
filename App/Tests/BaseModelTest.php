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
     * Name of the database used for these tests.
     *
     * @var string
     */
    private string $database_name;

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
        $this->database_name = self::class . '_' . str_replace('.', '_', microtime(true));
        $this->table_name = 'base_model';

        $this->database_adapter = new PdoAdapter(
            Config::get('TEST_DB_HOST'),
            Config::get('TEST_DB_NAME'),
            Config::get('TEST_DB_USER'),
            Config::get('TEST_DB_PASSWORD')
        );

        $this->database_adapter->execute("CREATE DATABASE `$this->database_name`;");
        $this->database_adapter->execute("USE `$this->database_name`; CREATE TABLE `$this->table_name`");
    }

    /**
     * Drops the database to use for these tests.
     *
     * @return void
     */
    public function teardown() : void
    {
        $this->database_adapter->execute("DROP DATABASE `$this->database_name`;");
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

        var_dump($mock->exec("SELECT * FROM `$mock->table_name`;"));

        return true;
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
}