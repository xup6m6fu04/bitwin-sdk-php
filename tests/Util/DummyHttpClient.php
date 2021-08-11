<?php

namespace Xup6m6fu04\Tests\Util;

use Xup6m6fu04\Bitwin\HTTPClient;
use Xup6m6fu04\Bitwin\Response;
use PHPUnit\Framework\TestCase;

class DummyHttpClient implements HTTPClient
{
    /** @var \PHPUnit\Framework\TestCase */
    private TestCase $testRunner;
    /** @var \Closure */
    private \Closure $mock;
    /** @var int */
    private $statusCode;

    public function __construct(TestCase $testRunner, \Closure $mock, $statusCode = 200)
    {
        $this->testRunner = $testRunner;
        $this->mock = $mock;
        $this->statusCode = $statusCode;
    }

    /**
     * @param string $url
     * @param array $data
     * @param array|null $headers Optional
     * @return Response
     */
    public function post(string $url, array $data, array $headers = null): Response
    {
        $ret = call_user_func($this->mock, $this->testRunner, 'POST', $url, $data, $headers);
        return new Response($this->statusCode, json_encode($ret));
    }
}
