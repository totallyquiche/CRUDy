<?php declare(strict_types=1);

namespace App\Models;

use App\DatabaseAdapter;

abstract class BaseModel
{
    /**
     * The name of the database table.
     *
     * @var string
     */
    protected string $table_name;

    /**
     * Database connection.
     *
     * @param DatabaseAdapter|null
     */
    private DatabaseAdapter $database_adapter;

    /**
     * Instantiate the model with a database adapter.
     *
     * @param DatabaseAdapter $database_adapter
     *
     * @return void
     */
    public function __construct(DatabaseAdapter $database_adapter)
    {
        $this->database_adapter = $database_adapter;
    }

    /**
     * Return all records for this model from the database.
     *
     * @return array
     */
    public function all() : array
    {
        return $this->database_adapter->query("SELECT * FROM `$this->table_name`;");
    }
}