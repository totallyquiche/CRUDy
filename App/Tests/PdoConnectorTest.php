<?php

declare(strict_types=1);

namespace App\Tests;

use App\Tests\Factories\MockPdoConnectorFactory;
use App\Tests\Helpers\TestHelper;

final class PdoConnectorTest extends Test
{
    /**
     * Tests that query() queries the database using the underlying PDO object.
     *
     * @return bool
     */
    public function test_query() : bool
    {
        $data_store_data = ['a', 'b', 'c'];

        $mock_pdo_connector = MockPdoConnectorFactory::create($data_store_data);

        return $mock_pdo_connector->query(TestHelper::getRandomString()) ===
            $data_store_data;
    }

    /**
     * Tests that execute() executes a query using the underlying PDO object.
     *
     * @return bool
     */
    public function test_execute() : bool
    {
        $affected_records_count = TestHelper::getRandomInteger();

        $mock_pdo_connector = MockPdoConnectorFactory::create(
            [],
            $affected_records_count
        );

        return $mock_pdo_connector->execute(TestHelper::getRandomString()) ===
            $affected_records_count;
    }
}