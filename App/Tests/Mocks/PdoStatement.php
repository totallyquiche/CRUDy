<?php

declare(strict_types=1);

namespace App\Tests\Mocks;

use \PDO;
use \PDOStatement as RealPdoStatement;

final class PdoStatement extends RealPdoStatement
{
    /**
     * Array representing the data this statement would return from the DB.
     *
     * @var array
     */
    private array $data;

    /**
     * Override fetch().
     *
     * @return array
     */
    public function fetch(
        int $mode = PDO::FETCH_DEFAULT,
        int $cursor_orientation = PDO::FETCH_ORI_NEXT,
        int $cursor_offset = 0
    ): mixed
    {
        return array_shift($this->data) ?? false;
    }

    /**
     * Setter method.
     *
     * @param array $data
     *
     * @return void
     */
    public function setData(array $data) : void
    {
        $this->data = $data;
    }
}