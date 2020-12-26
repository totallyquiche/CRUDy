<?php declare(strict_types=1);

namespace Tests;

interface TesterInterface
{
    /**
     * Call test methods and return a boolean indicating whether they all returned
     * true.
     *
     * @return bool
     */
    public function run() : bool;
}