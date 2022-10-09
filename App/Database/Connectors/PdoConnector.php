<?php

declare(strict_types=1);

namespace App\Database\Connectors;

use \PDO;

abstract class PdoConnector implements DatabaseConnector
{
    /**
     * @var PDO
     */
    protected PDO $pdo;

    /**
     * Handle instantiation.
     *
     * @param PDO $pdo
     *
     * @return void
     */
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Wrapper for PDO::query().
     *
     * @param string $query
     *
     * @return array
     */
    public function query(string $query) : array
    {
        $statement = $this->pdo->query($query);

        $results = [];

        while ($row = $statement->fetch()) {
            $results[] = $row;
        }

        return $results;
    }

    /**
     * Wrapper for PDO::execute().
     *
     * @param string $query
     *
     * @return int
     */
    public function execute(string $query) : int
    {
        return $this->pdo->exec($query);
    }
}