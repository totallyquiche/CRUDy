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
     * @var array
     */
    private array $params;

    /**
     * Set the request method.
     *
     * @param string $method
     * @param array  $headers
     * @param array  $params
     *
     * @return void
     */
    public function __construct(string $method, array $headers = [], array $params = [])
    {
        $this->setMethod($method);
        $this->setHeaders($headers);
        $this->setParams($params);
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

    /**
     * Set the request params.
     *
     * @param array $params
     *
     * @return void
     */
    public function setParams(array $params) : void
    {
        $this->params = $params;
    }

    /**
     * Get the request params.
     *
     * @return array
     */
    public function getParams() : array
    {
        return $this->params;
    }
}