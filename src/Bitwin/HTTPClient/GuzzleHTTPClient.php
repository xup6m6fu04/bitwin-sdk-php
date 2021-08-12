<?php

namespace Xup6m6fu04\Bitwin\HTTPClient;


use GuzzleHttp\Client;
use Xup6m6fu04\Bitwin\HTTPClient;
use Xup6m6fu04\Bitwin\Response;

class GuzzleHTTPClient implements HTTPClient
{
    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function post(string $url, array $data): Response
    {
        return $this->sendRequest($url, $data);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function sendRequest(string $url, array $data): Response
    {
        $client = new Client([
            'timeout' => 20,
            'connect_timeout' => 20
        ]);
        $response = $client->post($url, [
            'json' => $data
        ]);
        return new Response($response->getStatusCode(), $response->getBody(), $response->getHeaders());
    }
}