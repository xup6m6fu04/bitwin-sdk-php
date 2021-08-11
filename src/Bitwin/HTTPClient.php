<?php

namespace Xup6m6fu04\Bitwin;

/**
 * Interface HttpClientInterface
 *
 * @package Bitwin\Bitwin
 */
interface HTTPClient
{
    /**
     * Sends POST request to Bitwin API.
     *
     * @param string $url Request URL.
     * @param array $data Request body.
     * @param array|null $headers Request headers.
     * @return Response Response of API request.
     */
    public function post(string $url, array $data, array $headers = null): Response;
}
