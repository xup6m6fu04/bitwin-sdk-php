<?php

namespace Xup6m6fu04\Tests;

use PHPUnit\Framework\TestCase;
use Xup6m6fu04\Bitwin;
use Xup6m6fu04\Tests\Util\DummyHttpClient;

class MerchantWithdrawTest extends TestCase
{
    /**
     * @throws \Xup6m6fu04\Bitwin\Exception\BitwinSDKException
     */
    public function testMerchantWithdraw()
    {
        $config = [
            'merchant_id' => 'test_merchant_id',
            'sign_key' => 'test_sign_key',
            'access_key' => 'test_access_key',
            'is_prod_environment' => false
        ];
        $args = [
            'MerchantUserId' => 'YOZERO_USER_01',
            'MerchantWithdrawId' => 'YOZERO_WITHDRAW_01',
            'UserWallet' => '0x875EDa094F03Ed4c93adb3dbb77913F860dC888f',
            'Amount' => '1000000000', // 10 USDT
            'FiatCurrency' => 'RMB',
            'FiatCurrencyAmount' => '64.81',
            'Symbol' => 'USDT_ERC20',
            'CallBackUrl' => 'https://test.com/api/callback',
            'TimeStamp' => '1628664587'
        ];
        $mock = function ($testRunner, $httpMethod, $url, $data) use ($args, $config) {
            $testRunner->assertEquals('POST', $httpMethod);
            $testRunner->assertEquals('https://stage-api.bitwin.ai/api/v4/MerchantWithdraw', $url);
            $args['MerchantId'] = $config['merchant_id'];
            $args['Sign'] = $data['Sign'];
            $testRunner->assertEquals($args, $data);
            return [
                'WithdrawId' => '53304076324244832',
                'MerchantWithdrawId' => 'YOZERO_WITHDRAW_01',
                'ReturnCode' => '200',
                'ReturnMessage' => '',
                'Sign' => 'DD42670319C41ABF0986BD21DB1ADB1'
            ];
        };

        $bitwin = new Bitwin(new DummyHttpClient($this, $mock), $config);
        $response = $bitwin->api('MerchantWithdraw')->call($args);
        $this->assertEquals([
            'WithdrawId' => '53304076324244832',
            'MerchantWithdrawId' => 'YOZERO_WITHDRAW_01',
            'ReturnCode' => '200',
            'ReturnMessage' => '',
            'Sign' => 'DD42670319C41ABF0986BD21DB1ADB1'
        ], $response->getJSONDecodedBody());
        $this->assertEquals(200, $response->getHTTPStatus());
        $this->assertEquals(true, $response->isSucceeded());
        $this->assertIsArray($response->getHeaders());
    }
}