<?php declare(strict_types=1);

namespace App\Tests;

interface PerformsSetupInterface
{
    /**
     * Perform setup.
     *
     * @return void
     */
    public function setup() : void;
}