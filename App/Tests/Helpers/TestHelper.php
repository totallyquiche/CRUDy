<?php

declare(strict_types=1);

namespace App\Tests\Helpers;

final class TestHelper
{
    /**
     * Return a random string of the indicated length.
     *
     * @param int $length
     *
     * @return string
     */
    public static function getRandomString(int $length = 5) : string
    {
        $lower_case_characters = 'abcdefghijklmnopqrstuvwxyz';
        $upper_case_characters = strtoupper($lower_case_characters);
        $numbers = '0123456789';
        $special_characters = '!@#$%^&*()';

        $all_characters = $lower_case_characters .
            $upper_case_characters .
            $numbers .
            $special_characters;

        return substr(str_shuffle($all_characters), 0, $length);
    }

    /**
     * Return a random integer.
     *
     * @param int $max_value
     *
     * @return int
     */
    public static function getRandomInteger(int $max_value = 9999) : int
    {
        return rand(0, $max_value);
    }
}