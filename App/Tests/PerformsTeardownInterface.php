<?php declare(strict_types=1);

namespace App\Tests;

interface PerformsTeardownInterface
{
    /**
     * Perform teardown.
     *
     * @return void
     */
    public function teardown() : void;
}