<?php

namespace Xup6m6fu04\Tests;

use PHPUnit\Framework\TestCase;
use Xup6m6fu04\Bitwin;
use Xup6m6fu04\Tests\Util\DummyHttpClient;

class BuildRelationUserTest extends TestCase
{
    /**
     * @throws \Xup6m6fu04\Bitwin\Exception\BitwinSDKException
     */
    public function testQueryMerchantWithdraw()
    {
        $config = [
            'merchant_id' => 'test_merchant_id',
            'sign_key' => 'test_sign_key',
            'is_prod_environment' => false
        ];
        $args = [
            'MerchantUserId' => 'YOZERO_USER_01',
            'CallBackUrl' => 'https://test.com/api/callback',
            'TimeStamp' => '1628664587'
        ];
        $mock = function ($testRunner, $httpMethod, $url, $data) use ($args, $config) {
            $testRunner->assertEquals('POST', $httpMethod);
            $testRunner->assertEquals('https://stage-api.bitwin.ai/api/v3/BuildRelationUser', $url);
            $args['MerchantId'] = $config['merchant_id'];
            $args['Sign'] = $data['Sign'];
            $testRunner->assertEquals($args, $data);
            return [
                'QrcodeData' => 'BITWIN$eyJhY3Rpb24iOiJtb2JpbGUvdjMvdXNlci9iaW5kIiwiZGF0YSI6eyJuYW1lIjoiNDRFNkYyMDJEOTU2NDhDNTdBOEYwMTAyREMyQjlEREUiLCJjb2RlIjoiM0xEVkYiLCJtZXJjaGFudF9uYW1lIjoieW96ZXJvIn19',
                'QrcodeImageUrl' => 'https://stage-api.bitwin.ai/web/v3/bind/user/44E6F202D95648C57A8F0102DC2B9DDE',
                'ReturnCode' => '200',
                'ReturnMessage' => '',
                'Sign' => 'C00CA273DC3CA6CBDA81E2EB2B12B5D5'
            ];
        };

        $bitwin = new Bitwin(new DummyHttpClient($this, $mock), $config);
        $response = $bitwin->api('BuildRelationUser')->call($args);
        $this->assertEquals([
            'QrcodeData' => 'BITWIN$eyJhY3Rpb24iOiJtb2JpbGUvdjMvdXNlci9iaW5kIiwiZGF0YSI6eyJuYW1lIjoiNDRFNkYyMDJEOTU2NDhDNTdBOEYwMTAyREMyQjlEREUiLCJjb2RlIjoiM0xEVkYiLCJtZXJjaGFudF9uYW1lIjoieW96ZXJvIn19',
            'QrcodeImageUrl' => 'https://stage-api.bitwin.ai/web/v3/bind/user/44E6F202D95648C57A8F0102DC2B9DDE',
            'ReturnCode' => '200',
            'ReturnMessage' => '',
            'Sign' => 'C00CA273DC3CA6CBDA81E2EB2B12B5D5'
        ], $response->getJSONDecodedBody());
    }
}