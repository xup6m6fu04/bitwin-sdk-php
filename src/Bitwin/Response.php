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
    private int $httpStatus;
    /** @var string */
    private string $body;
    /** @var string[] */
    private array $headers;

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
     * Returns raw response body.
     *
     * @return string Raw request body.
     */
    public function getRawBody(): string
    {
        return $this->body;
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
     * Returns the value of the specified response header.
     *
     * @param string $name A String specifying the header name.
     * @return string|null A response header string, or null if the response does not have a header of that name.
     */
    public function getHeader(string $name): ?string
    {
        if (isset($this->headers[$name])) {
            return $this->headers[$name];
        }
        return null;
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
