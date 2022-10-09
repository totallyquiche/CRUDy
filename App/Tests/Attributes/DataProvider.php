<?php

declare(strict_types=1);

namespace App\Tests\Attributes;

use \Attribute;

#[Attribute]
final class DataProvider
{
    /**
     * Hanadle instantiation.
     *
     * @param string $method_name
     *
     * @return void
     */
    public function __construct(public string $method_name) {}
}