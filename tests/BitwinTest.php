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
            'is_prod_environment' => false
        ];
        $bitwin = new Bitwin($client, $config);
        $bitwin->api('no_exist')->call([]);
    }
}