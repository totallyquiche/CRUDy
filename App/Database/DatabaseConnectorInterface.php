<?php declare(strict_types=1);

namespace App\Database;

interface DatabaseConnectorInterface
{
    /**
     * Singleton to ensure we always use the same instance of this interface.
     *
     * @param string|null $db_host
     * @param string|null $db_name
     * @param string|null $db_user
     * @param string|null $db_password
     *
     * @return self
     */
    public static function getInstance(
        ?string $db_host = null,
        ?string $db_name = null,
        ?string $db_user = null,
        ?string $db_password = null
    ) : self;

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