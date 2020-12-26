<?php declare(strict_types=1);

namespace App\Database;

interface DatabaseAdapterInterface
{
    /**
     * Singleton to ensure we always use the same instance of this interface.
     *
     * @return DatabaseAdapterInterface
     */
    public static function getInstance() : DatabaseAdapterInterface;

    /**
     * Run a query and get the results.
     *
     * @param string $query
     *
     * @return array
     */
    public function query(string $query) : array;
}