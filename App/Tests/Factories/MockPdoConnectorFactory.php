<?php

declare(strict_types=1);

namespace App\Tests\Factories;

use App\Tests\Mocks\PdoConnector as MockPdoConnector;
use App\Tests\Mocks\Pdo as MockPdo;
use App\Tests\Mocks\PdoStatement as MockPdoStatement;

final class MockPdoConnectorFactory
{
    /**
     * Create a mock instance of PdoConnector.
     *
     * @param array $data
     * @param int   $affected_records_count
     *
     * @return MockPdoConnector
     */
    public static function create(
        array $data = [],
        int $affected_records_count = 5
    ) : MockPdoConnector
    {
        $mock_pdo = new MockPdo('');
        $mock_pdo->setAffectedRecordsCount($affected_records_count);

        $mock_pdo_connector = new MockPdoConnector($mock_pdo);

        $mock_pdo_statement = new MockPdoStatement;
        $mock_pdo_statement->setData($data);

        $mock_pdo->setPdoStatement($mock_pdo_statement);

        return $mock_pdo_connector;
    }
}