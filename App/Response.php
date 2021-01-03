<?php declare(strict_types=1);

namespace App;

class Response
{
    /**
     * Construct the Response.
     *
     * @param string $data
     */
    public function __construct(string $data)
    {
        $this->data = $data;
    }

    /**
     * Render the response as a string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->data;
    }
}