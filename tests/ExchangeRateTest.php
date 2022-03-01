<?php

namespace Xup6m6fu04\Tests;

use PHPUnit\Framework\TestCase;
use Xup6m6fu04\Bitwin;
use Xup6m6fu04\Tests\Util\DummyHttpClient;

class ExchangeRateTest extends TestCase
{
    /**
     * @throws \Xup6m6fu04\Bitwin\Exception\BitwinSDKException
     */
    public function testExchangeRate()
    {
        $config = [
            'merchant_id' => 'test_merchant_id',
            'sign_key' => 'test_sign_key',
            'access_key' => 'test_access_key',
            'is_prod_environment' => false
        ];
        $args = [
            'Symbol' => 'USDT_ERC20'
        ];
        $mock = function ($testRunner, $httpMethod, $url, $data) use ($args, $config) {
            $testRunner->assertEquals('POST', $httpMethod);
            $testRunner->assertEquals('https://stage-api.bitwin.ai/api/v4/ExchangeRate', $url);
            $args['MerchantId'] = $config['merchant_id'];
            $args['Sign'] = $data['Sign'];
            $testRunner->assertEquals($args, $data);
            return [
                'RMBRate' => '6.55',
                'RMBBuyRate' => '6.80',
                'ReturnCode' => '200',
                'ReturnMessage' => ''
            ];
        };

        $bitwin = new Bitwin(new DummyHttpClient($this, $mock), $config);
        $response = $bitwin->api('ExchangeRate')->call($args);
        $this->assertEquals([
            'RMBRate' => '6.55',
            'RMBBuyRate' => '6.80',
            'ReturnCode' => '200',
            'ReturnMessage' => ''
        ], $response->getJSONDecodedBody());
        $this->assertEquals(200, $response->getHTTPStatus());
        $this->assertEquals(true, $response->isSucceeded());
        $this->assertIsArray($response->getHeaders());
    }
}