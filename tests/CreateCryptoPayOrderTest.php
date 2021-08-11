<?php

namespace Xup6m6fu04\Tests;

use PHPUnit\Framework\TestCase;
use Xup6m6fu04\Bitwin;
use Xup6m6fu04\Tests\Util\DummyHttpClient;

class CreateCryptoPayOrderTest extends TestCase
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
            'MerchantUserId' => 'YOZERO_USER_01',
            'MerchantOrderId' => 'YOZERO_ORDER_01',
            'OrderDescription' => 'YOZERO_DESC_01',
            'Amount' => '700000000', // 7 USDT
            'MerchantRMB' => '45.38',
            'Symbol' => 'USDT_ERC20',
            'CallBackUrl' => 'https://test.com/api/callback',
            'TimeStamp' => '1628664587',
        ];
        $mock = function ($testRunner, $httpMethod, $url, $data) use ($args, $config) {
            $testRunner->assertEquals('POST', $httpMethod);
            $testRunner->assertEquals('https://stage-api.bitwin.ai/api/v3/CreateCryptoPayOrder', $url);
            $args['MerchantId'] = $config['merchant_id'];
            $args['Sign'] = $data['Sign'];
            $testRunner->assertEquals($args, $data);
            return [
                'OrderId' => '53298248131218784',
                'Qrcode' => 'https://stage-api.bitwin.ai/order/53298248131218784',
                'Amount' => '700000000',
                'RealAmount' => '700000000',
                'CryptoWallet' => '0x70E6a93eB33A9bf69Fcc30F01029083E7D5bb65f',
                'ReturnCode' => '200',
                'ReturnMessage' => '',
                'Sign' => '041FAA025359DEC6C8D4D283582E0456',
            ];
        };

        $bitwin = new Bitwin(new DummyHttpClient($this, $mock), $config);
        $response = $bitwin->api('CreateCryptoPayOrder')->call($args);
        $this->assertEquals([
            'OrderId' => '53298248131218784',
            'Qrcode' => 'https://stage-api.bitwin.ai/order/53298248131218784',
            'Amount' => '700000000',
            'RealAmount' => '700000000',
            'CryptoWallet' => '0x70E6a93eB33A9bf69Fcc30F01029083E7D5bb65f',
            'ReturnCode' => '200',
            'ReturnMessage' => '',
            'Sign' => '041FAA025359DEC6C8D4D283582E0456',
        ], $response->getJSONDecodedBody());
    }

}