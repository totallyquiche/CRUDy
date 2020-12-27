<?php declare(strict_types=1);

namespace App\Models;

use App\Database\DatabaseAdapterInterface;

abstract class BaseModel
{
    /**
     * The name of the database table.
     *
     * @var string
     */
    public string $table_name;

    /**
     * Database connection.
     *
     * @param DatabaseAdapterInterface|null
     */
    protected ?DatabaseAdapterInterface $database_adapter_interface;

    /**
     * Instantiate the model with a database adapter.
     *
     * @param DatabaseAdapterInterface $database_adapter_interface
     *
     * @return void
     */
    public function __construct(DatabaseAdapterInterface $database_adapter_interface)
    {
        $this->database_adapter_interface = $database_adapter_interface;
    }

    /**
     * Return all records for this model from the database.
     *
     * @return array
     */
    public function all() : array
    {
        return $this->database_adapter_interface->query("SELECT * FROM `$this->table_name`;");
    }
}