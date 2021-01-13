<?php declare(strict_types=1);

namespace App;

class Request
{
    /**
     * The target URI of the request.
     *
     * @var string
     */
    private $uri;

    /**
     * The request Method (e.g., POST, GET)
     *
     * @var string
     */
    private $method;

    /**
     * An array representing GET params sent with the request.
     *
     * @var array
     */
    private $queries;

    /**
     * An array representng POST data sent with the request.
     *
     * @var array
     */
    private $data;

    /**
     * Construct the request. Set the request URI.
     *
     * @param string $uri
     * @param string $method
     *
     * @return void
     */
    public function __construct(string $uri, string $method)
    {
        $this->uri = $uri;
        $this->method = $method;

        $this->queries = $this->parseQueries(
            parse_url($this->uri, PHP_URL_QUERY) ?? ''
        );

        $this->data = $this->getDataFromPost();
    }

    /**
     * Parse query params from the URI.
     *
     * @param string $uri
     *
     * @return array
     */
    private function parseQueries(string $uri) : array
    {
        $queries = [];

        parse_str($uri, $queries);

        return $queries;
    }

    /**
     * Get the data from the POST.
     *
     * @return array
     */
    private function getDataFromPost() : array
    {
        $data = [];

        foreach ($_POST as $key => $value) {
            $data[$key] = $value;
        }

        return $data;
    }

    /**
     * Return this Request's queries array.
     *
     * @return array
     */
    public function getQueries() : array
    {
        return $this->queries;
    }

    /**
     * Return this Request's URI.
     *
     * @return string
     */
    public function getUri() : string
    {
        return $this->uri;
    }
}