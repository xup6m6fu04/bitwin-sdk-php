<?php

namespace Xup6m6fu04\Bitwin\HTTPClient;


use GuzzleHttp\Client;
use Xup6m6fu04\Bitwin\HTTPClient;
use Xup6m6fu04\Bitwin\Response;

class GuzzleHTTPClient implements HTTPClient
{
    /**
     * @var array|mixed
     */
    private $args;

    public function __construct($args = [])
    {
        $this->args = $args;
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function post(string $url, array $data, array $headers = []): Response
    {
        return $this->sendRequest($url, $data, $headers);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function sendRequest(string $url, array $data, array $headers = []): Response
    {
        $args = array_merge([
            'timeout' => 20,
            'connect_timeout' => 20
        ], $this->args);

        $client = new Client($args);
        $response = $client->post($url, [
            'json' => $data,
            'headers' => $headers
        ]);
        return new Response($response->getStatusCode(), $response->getBody(), $response->getHeaders());
    }
}