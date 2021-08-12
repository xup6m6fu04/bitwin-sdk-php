<?php

namespace Xup6m6fu04\Bitwin;

/**
 * A class represents API response.
 *
 * @package Xup6m6fu04\Bitwin
 */
class Response
{
    /** @var int */
    private $httpStatus;
    /** @var string */
    private $body;
    /** @var string[] */
    private $headers;

    /**
     * Response constructor.
     *
     * @param int $httpStatus HTTP status code of response.
     * @param string $body Request body.
     * @param string[] $headers
     */
    public function __construct(int $httpStatus, string $body, $headers = [])
    {
        $this->httpStatus = $httpStatus;
        $this->body = $body;
        $this->headers = $headers;
    }

    /**
     * Returns HTTP status code of response.
     *
     * @return int HTTP status code of response.
     */
    public function getHTTPStatus(): int
    {
        return $this->httpStatus;
    }

    /**
     * Returns request is succeeded or not.
     *
     * @return bool Request is succeeded or not.
     */
    public function isSucceeded(): bool
    {
        return 200 <= $this->httpStatus && $this->httpStatus <= 299;
    }

    /**
     * Returns response body as array (it means, returns JSON decoded body).
     *
     * @return array Request body that is JSON decoded.
     */
    public function getJSONDecodedBody(): array
    {
        return json_decode($this->body, true);
    }

    /**
     * Returns all of response headers.
     *
     * @return string[] All of the response headers.
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }
}
