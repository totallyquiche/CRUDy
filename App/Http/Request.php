<?php declare(strict_types=1);

namespace App\Http;

class Request
{
    /**
     * @var string
     */
    private string $method;

    /**
     * Set the request method.
     *
     * @param string $method
     *
     * @return void
     */
    public function __construct(string $method)
    {
        $this->setMethod($method);
    }

    /**
     * Set the request method.
     *
     * @param string $method
     *
     * @return void
     */
    public function setMethod(string $method) : void
    {
        $this->method = $method;
    }

    /**
     * Get the request method.
     *
     * @return string
     */
    public function getMethod() : string
    {
        return $this->method;
    }
}