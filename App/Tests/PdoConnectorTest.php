<?php

declare(strict_types=1);

namespace App\Tests;

use App\Tests\Factories\MockPdoConnectorFactory;

final class PdoConnectorTest extends Test
{
    /**
     * Tests that query() queries the database using the underlying PDO object.
     *
     * @return bool
     */
    public function test_query() : bool
    {
        $expected_results = ['a', 'b', 'c'];

        $mock_pdo_connector = MockPdoConnectorFactory::create($expected_results);

        // Note that the mock always assumes the query string is asking for all
        // records since we never want to test the query language itself.
        return $mock_pdo_connector->query('') === $expected_results;
    }
}