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
     * An array representing GET params sent with the request.
     *
     * @var array
     */
    private $queries;

    /**
     * Construct the request. Set the request URI.
     *
     * @param string
     *
     * @return void
     */
    public function __construct(string $uri)
    {
        $this->uri = $uri;

        $this->queries = $this->parseQueries(
            parse_url($this->uri, PHP_URL_QUERY) ?? ''
        );
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
     * Return this Request's queries array.
     *
     * @return array
     */
    public function getQueries() : array
    {
        return $this->queries;
    }
}