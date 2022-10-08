<?php

declare(strict_types=1);

namespace App\Database\Connectors;

interface DatabaseConnector
{
    /**
     * Run a query and get the results.
     *
     * @param string $query
     *
     * @return array
     */
    public function query(string $query) : array;

    /**
     * Execute a query.
     *
     * @param string $query
     *
     * @return void
     */
    public function execute(string $query) : void;
}