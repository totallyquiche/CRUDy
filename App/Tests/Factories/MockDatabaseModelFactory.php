<?php

declare(strict_types=1);

namespace App\Tests\Factories;

use App\Tests\Mocks\DatabaseModel as MockDatabaseModel;

final class MockDatabaseModelFactory
{
    /**
     * Create a mock instance of Model.
     *
     * @return MockDatabaseModel
     */
    public static function create(
        array $data,
        string $primary_key,
        int $id
    ) : MockDatabaseModel
    {
        $mock_model = new MockDatabaseModel(
            MockPdoConnectorFactory::create([$data])
        );

        $mock_model->setPrimaryKey($primary_key);
        $mock_model->setId($id);

        return $mock_model;
    }
}