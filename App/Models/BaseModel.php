<?php declare(strict_types=1);

namespace App\Models;

use App\Database\DatabaseConnectorInterface;

abstract class BaseModel
{
    /**
     * The name of the database table.
     *
     * @var string
     */
    public string $table_name;

    /**
     * The primary key of the database table.
     *
     * @var string
     */
    public string $primary_key = 'id';

    /**
     * Database connection.
     *
     * @param DatabaseConnectorInterface|null
     */
    protected ?DatabaseConnectorInterface $database_connector;

    /**
     * Instantiate the model with a database adapter.
     *
     * @param DatabaseConnectorInterface $database_connector
     *
     * @return void
     */
    public function __construct(DatabaseConnectorInterface $database_connector)
    {
        $this->database_connector = $database_connector;
    }

    /**
     * Return all records for this model from the database.
     *
     * @return array
     */
    public function all() : array
    {
        return $this->database_connector->query("SELECT * FROM `$this->table_name`;");
    }

    /**
     * Find a record in the database by ID and return it.
     *
     * @param int $id
     *
     * @return array
     */
    public function find(int $id) : array
    {
        return $this->database_connector->query(
            "SELECT * FROM `$this->table_name` WHERE `$this->primary_key` = $id"
        );
    }
}