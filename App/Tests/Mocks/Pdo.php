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
     * @var int
     */
    private $affected_records_count;

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
     * @param string   $query
     * @param null|int $fetch_mode
     * @param mixed    $fetch_mod_args
     *
     * @return PDOStatement|false
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

    /**
     * Override exec().
     *
     * @param string $statement
     *
     * @return int|false
     */
    public function exec(string $statement) : int|false
    {
        return $this->affected_records_count;
    }

    /**
     * Setter method.
     *
     * @param int $affected_records_count
     *
     * @return void
     */
    public function setAffectedRecordsCount(int $affected_records_count) : void
    {
        $this->affected_records_count = $affected_records_count;
    }
}