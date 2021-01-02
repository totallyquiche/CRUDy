<?php declare(strict_types=1);

namespace App\Tests;

use App\Database\PdoAdapter;
use App\Config;

class PdoAdapterTest extends BaseTest
{
    /**
     * Test that getInstance() returns the same instance of the PdoAdapter.
     *
     * @return bool
     */
    public function test_getInstance_returns_same_instance()
    {
        return PdoAdapter::getInstance() === PdoAdapter::getInstance();
    }

    /**
     * Test that getInstance() returns different instances when different DB info
     * is used.
     *
     * @return bool
     */
    public function test_getInstance_returns_different_instances_with_different_db_info()
    {
        $first_instance = PdoAdapter::getInstance(
            Config::get('DB_HOST'),
            Config::get('DB_NAME'),
            Config::get('DB_USER'),
            Config::get('DB_PASSWORD')
        );

        $second_instance = PdoAdapter::getInstance(
            Config::get('TEST_DB_HOST'),
            Config::get('TEST_DB_NAME'),
            Config::get('TEST_DB_USER'),
            Config::get('TEST_DB_PASSWORD')
        );

        return $first_instance != $second_instance;
    }

    /**
     * Test that, after creating a new instance by passing in new DB info, getInstance()
     * returns the same instance.
     *
     * @return bool
     */
    public function test_getInstance_returns_same_instance_after_creating_a_new_instance()
    {
        $first_instance = PdoAdapter::getInstance(
            Config::get('DB_HOST'),
            Config::get('DB_NAME'),
            Config::get('DB_USER'),
            Config::get('DB_PASSWORD')
        );

        $second_instance = PdoAdapter::getInstance(
            Config::get('TEST_DB_HOST'),
            Config::get('TEST_DB_NAME'),
            Config::get('TEST_DB_USER'),
            Config::get('TEST_DB_PASSWORD')
        );

        $third_instance = PdoAdapter::getInstance();

        return $second_instance === $third_instance;
    }
}