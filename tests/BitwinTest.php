<?php

namespace Xup6m6fu04\Tests;

use PHPUnit\Framework\TestCase;
use Xup6m6fu04\Bitwin;
use Xup6m6fu04\Bitwin\Exception\BitwinSDKException;
use Xup6m6fu04\Bitwin\Exception\InvalidArgumentException;
use Xup6m6fu04\Bitwin\HTTPClient\GuzzleHTTPClient;

class BitwinTest extends TestCase
{
    public function testInstantiatingWithoutMerchantIdThrows()
    {
        $this->expectException(BitwinSDKException::class);
        $this->expectExceptionMessage('Required "merchant_id"');
        $client = new GuzzleHTTPClient();
        $config = [
            'sign_key' => 'test_sign_key',
            'access_key' => 'test_access_key',
            'is_prod_environment' => false
        ];
        new Bitwin($client, $config);
    }

    public function testInstantiatingWithoutSignKeyThrows()
    {
        $this->expectException(BitwinSDKException::class);
        $this->expectExceptionMessage('Required "sign_key"');
        $client = new GuzzleHTTPClient();
        $config = [
            'merchant_id' => 'test_merchant_id',
            'access_key' => 'test_access_key',
            'is_prod_environment' => false
        ];
        new Bitwin($client, $config);
    }

    public function testInstantiatingWithoutAccessKeyThrows()
    {
        $this->expectException(BitwinSDKException::class);
        $this->expectExceptionMessage('Required "access_key"');
        $client = new GuzzleHTTPClient();
        $config = [
            'merchant_id' => 'test_merchant_id',
            'sign_key' => 'test_sign_key',
            'is_prod_environment' => false
        ];
        new Bitwin($client, $config);
    }

    /**
     * @throws \Xup6m6fu04\Bitwin\Exception\BitwinSDKException
     */
    public function testInstantiating()
    {
        $client = new GuzzleHTTPClient();
        $config = [
            'merchant_id' => 'test_merchant_id',
            'sign_key' => 'test_sign_key',
            'access_key' => 'test_access_key',
            'is_prod_environment' => false
        ];
        $bitwin = new Bitwin($client, $config);
        $this->assertInstanceOf('Xup6m6fu04\Bitwin\HTTPClient', $bitwin->getClient());
    }

    /**
     * @throws \Xup6m6fu04\Bitwin\Exception\BitwinSDKException
     */
    public function testApiParamThrows()
    {
        $this->expectException(InvalidArgumentException::class);
        $client = new GuzzleHTTPClient();
        $config = [
            'merchant_id' => 'test_merchant_id',
            'sign_key' => 'test_sign_key',
            'access_key' => 'test_access_key',
            'is_prod_environment' => false
        ];
        $bitwin = new Bitwin($client, $config);
        $bitwin->api('no_exist')->call([]);
    }

    /**
     * @throws \Xup6m6fu04\Bitwin\Exception\BitwinSDKException
     */
    public function testVerifySign()
    {
        $client = new GuzzleHTTPClient();
        $config = [
            'merchant_id' => 'test_merchant_id',
            'sign_key' => 'test_sign_key',
            'access_key' => 'test_access_key',
            'is_prod_environment' => false
        ];
        $args = [
            "MerchantId" => "your_merchant_id",
            "MerchantUserId" => "YOZERO_USER_01",
            "UserName" => "48847933077253904",
            "BTC" => "2My4ttAncyVKbAQWwAMLsG7JCMif3KkpHBC",
            "ETH" => "0xe4f3Ad1005ac2FbD22f7F22871A8Ea1d688866a0",
            "USDT_ERC20" => "0x7F8FAe2d400cD767d4184638eD296DBc44F218Bb",
            "USDT_TRC20" => "TYGzJX3tyDy81eQGGw92US821LiykuHPFi",
            "USDT_BEP20" => "0x84e6B02d0223c004bc350F481038371Cfd7e4512",
            "Sign" => "EF628A06A7038E80E3EB51A57F4777E2"
        ];
        $bitwin = new Bitwin($client, $config);
        $result = $bitwin->verifySign($args);
        $this->assertEquals(true, $result);
    }
}