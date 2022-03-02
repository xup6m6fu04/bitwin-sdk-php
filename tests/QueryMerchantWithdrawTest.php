<?php

namespace Xup6m6fu04\Tests;

use PHPUnit\Framework\TestCase;
use Xup6m6fu04\Bitwin;
use Xup6m6fu04\Tests\Util\DummyHttpClient;

class QueryMerchantWithdrawTest extends TestCase
{
    /**
     * @throws \Xup6m6fu04\Bitwin\Exception\BitwinSDKException
     */
    public function testQueryMerchantWithdraw()
    {
        $config = [
            'merchant_id' => 'test_merchant_id',
            'sign_key' => 'test_sign_key',
            'access_key' => 'test_access_key',
            'is_prod_environment' => false
        ];
        $args = [
            'MerchantWithdrawId' => 'YOZERO_WITHDRAW_01',
            'WithdrawId' => '53304076324244832',
            'TimeStamp' => '1628664587'
        ];
        $mock = function ($testRunner, $httpMethod, $url, $data) use ($args, $config) {
            $testRunner->assertEquals('POST', $httpMethod);
            $testRunner->assertEquals('https://stage-api.bitwin.ai/api/v4/QueryMerchantWithdraw', $url);
            $args['MerchantId'] = $config['merchant_id'];
            $args['Sign'] = $data['Sign'];
            $testRunner->assertEquals($args, $data);
            return [
                'MerchantUserId' => 'YOZERO_USER_01',
                'UserWallet' => '0x875EDa094F03Ed4c93adb3dbb77913F860dC888f',
                'WithdrawId' => '53304076324244832',
                'MerchantWithdrawId' => 'YOZERO_WITHDRAW_01',
                'Symbol' => 'USDT_ERC20',
                'Amount' => '1000000000',
                'FiatCurrency' => 'CNY',
                'FiatCurrencyAmount' => '64.81',
                'ExchangeRMB' => '68.00',
                'Status' => 'PENDING',
                'ReturnCode' => '200',
                'ReturnMessage' => '',
                'Sign' => '23821A64B674B01D2D35CF0DCC41CCB3'
            ];
        };

        $bitwin = new Bitwin(new DummyHttpClient($this, $mock), $config);
        $response = $bitwin->api('QueryMerchantWithdraw')->call($args);
        $this->assertEquals([
            'MerchantUserId' => 'YOZERO_USER_01',
            'UserWallet' => '0x875EDa094F03Ed4c93adb3dbb77913F860dC888f',
            'WithdrawId' => '53304076324244832',
            'MerchantWithdrawId' => 'YOZERO_WITHDRAW_01',
            'Symbol' => 'USDT_ERC20',
            'Amount' => '1000000000',
            'FiatCurrency' => 'CNY',
            'FiatCurrencyAmount' => '64.81',
            'ExchangeRMB' => '68.00',
            'Status' => 'PENDING',
            'ReturnCode' => '200',
            'ReturnMessage' => '',
            'Sign' => '23821A64B674B01D2D35CF0DCC41CCB3'
        ], $response->getJSONDecodedBody());
        $this->assertEquals(200, $response->getHTTPStatus());
        $this->assertEquals(true, $response->isSucceeded());
        $this->assertIsArray($response->getHeaders());
    }
}