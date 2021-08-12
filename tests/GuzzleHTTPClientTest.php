<?php

namespace Xup6m6fu04\Tests;

use PHPUnit\Framework\TestCase;
use Xup6m6fu04\Bitwin\HTTPClient\GuzzleHTTPClient;

class GuzzleHTTPClientTest extends TestCase
{
    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function testPostRequest()
    {
        $client = new GuzzleHTTPClient();
        $response = $client->post('https://httpbin.org/post', []);
        $this->assertEquals(200, $response->getHTTPStatus());
    }
}