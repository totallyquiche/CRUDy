<?php

declare(strict_types=1);

namespace App;

interface Model
{
    /**
     * Return all records for this model from the database.
     *
     * @return array
     */
    public function all() : array;

    /**
     * Find a record in the database by ID and return it.
     *
     * @param int $id
     *
     * @return static
     */
    public function find(int $id) : static;
}