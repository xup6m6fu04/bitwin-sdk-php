<?php

namespace Xup6m6fu04\Tests;

use PHPUnit\Framework\TestCase;
use Xup6m6fu04\Bitwin;
use Xup6m6fu04\Tests\Util\DummyHttpClient;

class QueryCryptoPayOrderTest extends TestCase
{
    /**
     * @throws \Xup6m6fu04\Bitwin\Exception\BitwinSDKException
     */
    public function testCreateCryptoPayOrder()
    {
        $config = [
            'merchant_id' => 'test_merchant_id',
            'sign_key' => 'test_sign_key',
            'is_prod_environment' => false
        ];
        $args = [
            'MerchantOrderId' => 'YOZERO_ORDER_01',
            'OrderId' => '53298248131218784',
            'TimeStamp' => '1628664587',
        ];
        $mock = function ($testRunner, $httpMethod, $url, $data) use ($args, $config) {
            $testRunner->assertEquals('POST', $httpMethod);
            $testRunner->assertEquals('https://stage-api.bitwin.ai/api/v3/QueryCryptoPayOrder', $url);
            $args['MerchantId'] = $config['merchant_id'];
            $args['Sign'] = $data['Sign'];
            $testRunner->assertEquals($args, $data);
            return [
                'OrderId' => '53298248131218784',
                'MerchantOrderId' => 'YOZERO_ORDER_01',
                'MerchantUserId' => 'YOZERO_USER_01',
                'OrderDescription' => 'YOZERO_DESC_01',
                'Symbol' => 'USDT_ERC20',
                'Amount' => '700000000',
                'RealAmount' => '700000000',
                'MerchantRMB' => '45.38',
                'ExchangeRMB' => '45.85',
                'OrderStatus' => 'SUCCESS',
                'CallBackUrl' => 'https://test.com/api/callback',
                'ReturnCode' => '200',
                'ReturnMessage' => '',
                'Sign' => 'ED8B4222F79429E05B5F4E2F0BC49944'
            ];
        };

        $bitwin = new Bitwin(new DummyHttpClient($this, $mock), $config);
        $response = $bitwin->api('QueryCryptoPayOrder')->call($args);
        $this->assertEquals([
            'OrderId' => '53298248131218784',
            'MerchantOrderId' => 'YOZERO_ORDER_01',
            'MerchantUserId' => 'YOZERO_USER_01',
            'OrderDescription' => 'YOZERO_DESC_01',
            'Symbol' => 'USDT_ERC20',
            'Amount' => '700000000',
            'RealAmount' => '700000000',
            'MerchantRMB' => '45.38',
            'ExchangeRMB' => '45.85',
            'OrderStatus' => 'SUCCESS',
            'CallBackUrl' => 'https://test.com/api/callback',
            'ReturnCode' => '200',
            'ReturnMessage' => '',
            'Sign' => 'ED8B4222F79429E05B5F4E2F0BC49944'
        ], $response->getJSONDecodedBody());
        $this->assertEquals(200, $response->getHTTPStatus());
        $this->assertEquals(true, $response->isSucceeded());
        $this->assertIsArray($response->getHeaders());
    }
}