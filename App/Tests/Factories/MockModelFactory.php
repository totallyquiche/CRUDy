<?php

declare(strict_types=1);

namespace App\Tests\Factories;

use App\Tests\Mocks\Model as MockModel;

final class MockModelFactory
{
    /**
     * Create a mock instance of Model.
     *
     * @return MockModel
     */
    public static function create(
        array $data,
        string $primary_key,
        int $id
    ) : MockModel
    {
        $mock_model = new MockModel(
            MockPdoConnectorFactory::create([$data])
        );

        $mock_model->setPrimaryKey($primary_key);
        $mock_model->setId($id);

        return $mock_model;
    }
}