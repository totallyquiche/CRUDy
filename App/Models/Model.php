<?php

declare(strict_types=1);

namespace App\Models;

use App\Database\Connectors\DatabaseConnector;

abstract class Model
{
    /**
     * Database connection.
     *
     * @param DatabaseConnector|null
     */
    protected ?DatabaseConnector $database_connector;

    /**
     * Instantiate the model with a database connector.
     *
     * @param DatabaseConnector $database_connector
     *
     * @return void
     */
    public function __construct(DatabaseConnector $database_connector)
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
        $table_name = $this->getTableName();

        $results = $this->database_connector->query("SELECT * FROM `$table_name`;");

        $objects = [];

        foreach ($results as $result) {
            $object = new static($this->database_connector);

            foreach ($result as $key => $value) {
                $object->{$key} = $value;
            }

            $objects[] = $object;
        }

        return $objects;
    }

    /**
     * Find a record in the database by ID and return it.
     *
     * @param int $id
     *
     * @return static
     */
    public function find(int $id) : static
    {
        $table_name = $this->getTableName();
        $primary_key = $this->getPrimaryKey();

        $results = $this->database_connector->query(
            "SELECT * FROM `$table_name` WHERE `$primary_key` = $id"
        );

        $objects = [];

        foreach ($results as $result) {
            $object = new static($this->database_connector);

            foreach ($result as $key => $value) {
                $object->{$key} = $value;
            }

            $objects[] = $object;
        }

        return $objects[0];
    }

    /**
     * Get the DB table name corresponding to the model.
     *
     * @return string
     */
    abstract public function getTableName() : string;

    /**
     * Get the primary key corresponding to the DB table.
     *
     * @return string
     */
    abstract public function getPrimaryKey() : string;
}