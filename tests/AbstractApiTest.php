<?php

namespace Xup6m6fu04\Tests;

use PHPUnit\Framework\TestCase;
use Xup6m6fu04\Bitwin\Apis\AbstractApi;
use Xup6m6fu04\Bitwin\Exception\BitwinSDKException;
use Xup6m6fu04\Tests\Util\DummyHttpClient;

class AbstractApiTest extends TestCase
{
    /**
     * @var \Xup6m6fu04\Bitwin\Apis\AbstractApi
     */
    private $abstractApiTest;

    public function setUp(): void
    {
        $this->abstractApiTest = $this->getMockForAbstractClass(AbstractApi::class, [], '', false);
    }

    public function testAbstractApiHTTPClientThrows()
    {
        $this->expectException(BitwinSDKException::class);
        $this->expectExceptionMessage('httpClient must be set when call APIs.');
        new $this->abstractApiTest(null, 'test_url', 'test_sign_key', 'test_access_key', 'merchant_id');
    }

    public function testAbstractApiOrderUrlThrows()
    {
        $this->expectException(BitwinSDKException::class);
        $this->expectExceptionMessage('endpointBase must be set when call APIs.');
        $httpClient = new DummyHttpClient($this, function(){});
        new $this->abstractApiTest($httpClient, null, 'test_sign_key', 'test_access_key', 'merchant_id');
    }

    public function testAbstractApiOrderSignKeyThrows()
    {
        $this->expectException(BitwinSDKException::class);
        $this->expectExceptionMessage('signKey must be set when call APIs.');
        $httpClient = new DummyHttpClient($this, function(){});
        new $this->abstractApiTest($httpClient, 'test_url', null, 'test_access_key', 'merchant_id');
    }

    public function testAbstractApiOrderAccessKeyThrows()
    {
        $this->expectException(BitwinSDKException::class);
        $this->expectExceptionMessage('accessKey must be set when call APIs.');
        $httpClient = new DummyHttpClient($this, function(){});
        new $this->abstractApiTest($httpClient, 'test_url', 'test_sign_key', null, 'merchant_id');
    }

    public function testAbstractApiOrderMerchantIdThrows()
    {
        $this->expectException(BitwinSDKException::class);
        $this->expectExceptionMessage('merchantId must be set when call APIs.');
        $httpClient = new DummyHttpClient($this, function(){});
        new $this->abstractApiTest($httpClient, 'test_url', 'test_sign_key', 'test_access_key', null);
    }
}