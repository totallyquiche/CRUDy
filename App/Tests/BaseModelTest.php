<?php declare(strict_types=1);

namespace App\Tests;

use App\Models\BaseModel;
use App\Database\DatabaseAdapterInterface;
use App\Database\PdoAdapter;
use \ReflectionObject;

class BaseModelTest extends BaseTest
{
    /**
     * Test constructor sets the database adapter.
     *
     * @return bool
     */
    public function test_constructor_set_database_adapter() : bool
    {
        $pdo_adapter = new PdoAdapter;

        $mock = $this->getBaseModelMock($pdo_adapter);

        $reflection = new ReflectionObject($mock);
        $database_adapter_interface_property = $reflection->getProperty('database_adapter_interface');
        $database_adapter_interface_property->setAccessible(true);
        $database_adapter = $database_adapter_interface_property->getValue($mock);

        return $pdo_adapter === $database_adapter;
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
                //
            }
        CLASS;

        eval($mock_class);

        $fully_qualified_class_name = 'App\\Models\\' . $class_name;

        return new $fully_qualified_class_name($database_adapter_interface);
    }
}