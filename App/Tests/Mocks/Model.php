<?php

declare(strict_types=1);

namespace App\Tests\Mocks;

use App\Models\Model as RealModel;

use App\Tests\Helpers\TestHelper;

final class Model extends RealModel {
    /**
     * Primary key on the DB.
     *
     * @var string
     */
    private string $primary_key;

    /**
     * Primary ID.
     *
     * @var int
     */
    private int $id;

    /**
     * Getter method;
     *
     * @return string
     */
    public function getTableName(): string
    {
        return TestHelper::getRandomString();
    }

    /**
     * Setter method;
     *
     * @param string $primary_key
     *
     * @return void
     */
    public function setPrimaryKey(string $primary_key) : void
    {
        $this->primary_key = $primary_key;
    }

    /**
     * Getter method;
     *
     * @return string
     */
    public function getPrimaryKey() : string
    {
        return $this->primary_key;
    }

    /**
     * Setter method.
     *
     * @return int
     */
    public function setId(int $id) : void
    {
        $this->id = $id;
    }

    /**
     * Getter method.
     *
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }
}