<?php

declare(strict_types=1);

namespace App\Tests;

use App\Tests\Factories\MockModelFactory;
use App\Tests\Mocks\Model as MockModel;
use App\Tests\Factories\MockPdoConnectorFactory;
use App\Tests\Helpers\TestHelper;

final class ModelTest extends Test
{
    /**
     * Test that all() returns an array objects representing the model.
     *
     * @return bool
     */
    public function test_all_returns_expected_object_types() : bool
    {
        $data = TestHelper::getDataStoreData();

        $mock_model = new MockModel(
            MockPdoConnectorFactory::create($data)
        );

        foreach ($mock_model->all() as $record) {
            if (get_class($record) !== get_class($mock_model)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Test that all() returns the expected number of objects.
     *
     * @return bool
     */
    public function test_all_returns_expected_number_of_objects() : bool
    {
        $data = TestHelper::getDataStoreData();

        $mock_model = new MockModel(
            MockPdoConnectorFactory::create($data)
        );

        return count($data) === count($mock_model->all());
    }

    /**
     * Test that find() returns the expected object type.
     *
     * @return bool
     */
    public function test_find_returns_expected_object_type() : bool
    {
        $primary_key = TestHelper::getRandomString();
        $id = TestHelper::getRandomInteger();
        $data = TestHelper::getRandomStringArray();
        $data[$primary_key] = $id;

        $mock_model = MockModelFactory::create($data, $primary_key, $id);

        $record = $mock_model->find($id);

        return get_class($record) === get_class($mock_model);
    }

    /**
     * Test that find() returns the object with the expected properties.
     *
     * @return bool
     */
    public function test_find_returns_object_with_expected_properties() : bool
    {
        $primary_key = TestHelper::getRandomString();
        $id = TestHelper::getRandomInteger();
        $data = TestHelper::getRandomStringArray();
        $data[$primary_key] = $id;

        $mock_model = MockModelFactory::create($data, $primary_key, $id);

        $record = $mock_model->find($id);

        foreach ($data as $key => $value) {
            if (!isset($record->{$key}) || $record->{$key} !== $value) {
                return false;
            }
        }

        return true;
    }
}