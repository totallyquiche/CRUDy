<?php

declare(strict_types=1);

namespace App\Tests\Mocks;

use \PDO as RealPdo;
use \PdoStatement;

final class Pdo extends RealPdo
{
    /**
     * @var PdoStatement
     */
    private PdoStatement $pdo_statement;

    /**
     * Override constructor().
     *
     * @return void
     */
    public function __construct(
        string $dsn,
        ?string $username = null,
        ?string $password = null,
        ?string $options = null
    ) {}

    /**
     * Override query().
     *
     * @return array
     */
    public function query(
        string $query,
        ?int $fetch_mode = null,
        mixed ...$fetch_mod_args
    ) : PDOStatement|false
    {
        return $this->pdo_statement;
    }

    /**
     * Setter method.
     *
     * @param PdoStatement
     *
     * @return void
     */
    public function setPdoStatement(PdoStatement $pdo_statement) : void
    {
        $this->pdo_statement = $pdo_statement;
    }
}