<?php declare(strict_types=1);

namespace App\Http;

class Request
{
    /**
     * @var string
     */
    private string $method;

    /**
     * @var array
     */
    private array $headers;

    /**
     * Set the request method.
     *
     * @param string $method
     * @param array  $headers
     *
     * @return void
     */
    public function __construct(string $method, array $headers = [])
    {
        $this->setMethod($method);
        $this->setHeaders($headers);
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

    /**
     * Set the request headers.
     *
     * @param array $headers
     *
     * @return void
     */
    public function setHeaders(array $headers) : void
    {
        $this->headers = $headers;
    }

    /**
     * Get the request headers.
     *
     * @return array
     */
    public function getHeaders() : array
    {
        return $this->headers;
    }
}