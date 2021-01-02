<?php declare(strict_types=1);

namespace App\Tests;

use App\Database\PdoAdapter;

class PdoAdapterTest extends BaseTest
{
    /**
     * Test that getInstance() returns the same instance of the PdoAdapter.
     *
     * @return bool
     */
    public function test_getInstance_returns_same_instance()
    {
        $old_instance = PdoAdapter::getInstance();

        $new_instance = PdoAdapter::getInstance();

        return $old_instance === $new_instance;
    }
}