# Bitwin SDK for PHP (v4)

🌍 *[English](README.md) ∙ [繁體中文](README_zh-TW.md) ∙ [简体中文](README_zh-CN.md)*

[![Build Status](https://www.travis-ci.com/xup6m6fu04/bitwin-sdk-php.svg?branch=master)](https://www.travis-ci.com/xup6m6fu04/bitwin-sdk-php)
[![codecov](https://codecov.io/gh/xup6m6fu04/bitwin-sdk-php/branch/master/graph/badge.svg)](https://codecov.io/gh/xup6m6fu04/bitwin-sdk-php)
[![FOSSA Status](https://app.fossa.com/api/projects/git%2Bgithub.com%2Fxup6m6fu04%2Fbitwin-sdk-php.svg?type=shield)](https://app.fossa.com/projects/git%2Bgithub.com%2Fxup6m6fu04%2Fbitwin-sdk-php?ref=badge_shield)

## Introduction
The BITWIN SDK for PHP makes it easy to develop bots using BITWIN merchant api, and you can create a sample client within minutes.

## Documentation

See the official API documentation for more information.

- Simple Chinese: https://bitwin.ai/api_manual_latest.html

## Requirements

This library requires PHP 7.2.5 or later.

## Installation ##

```sh
$ composer require xup6m6fu04/bitwin-sdk-php
```

## Configuration ##

```php
<?php

require "vendor/autoload.php";

use Xup6m6fu04\Bitwin;
use Xup6m6fu04\Bitwin\Exception\BitwinSDKException;
use Xup6m6fu04\Bitwin\HTTPClient\GuzzleHTTPClient;

$c = new Example();
$c->createCryptoPayOrder();

class Example
{
    /**
     * @var \Xup6m6fu04\Bitwin\HTTPClient\GuzzleHTTPClient
     */
    private $httpClient;
    /**
     * @var \Xup6m6fu04\Bitwin
     */
    private $bitwin;

    /**
     * @throws \Xup6m6fu04\Bitwin\Exception\BitwinSDKException
     */
    public function __construct()
    {
        $this->httpClient = new GuzzleHTTPClient();
        $this->bitwin = new Bitwin($this->httpClient, [
            'merchant_id' => 'your_merchant_id',
            'sign_key' => 'your_sign_key',
            'access_key' => 'your_access_key',
            'is_prod_environment' => false, // true is production environment
        ]);
    }

    /**
     * Create Crypto Pay Order
     * 建立付款訂單
     * 建立付款订单
     */
    public function createCryptoPayOrder()
    {
        try {
            $args = [
                'MerchantUserId' => 'YOZERO_USER_01',
                'MerchantOrderId' => 'YOZERO_ORDER_01',
                'OrderDescription' => 'YOZERO_DESC_01',
                'Amount' => '700000000', // 7 USDT
                'FiatCurrency' => 'CNY',
                'FiatCurrencyAmount' => '45.38',
                'Symbol' => 'USDT_ERC20',
                'CallBackUrl' => 'https://test.com/api/callback',
                'TimeStamp' => '1628664587'
            ];
            $result = $this->bitwin->api('CreateCryptoPayOrder')->call($args);
            print_r($result->getJSONDecodedBody());
            /**
             * Successfully printed the result
             * Array
             * (
             *     [OrderId] => 53298248131218784
             *     [Qrcode] => https://stage-api.bitwin.ai/order/53298248131218784
             *     [Amount] => 700000000
             *     [RealAmount] => 700000000
             *     [CryptoWallet] => 0x70E6a93eB33A9bf69Fcc30F01029083E7D5bb65f
             *     [ReturnCode] => 200
             *     [ReturnMessage] =>
             *     [Sign] => 041FAA025359DEC6C8D4D283582E0456
             * )
             */
        } catch (BitwinSDKException | Exception $e) {
            echo $e->getMessage();
        }
    }
    ...
```
## Example ##
### *[Please refer to the sample code](src/Example.php)*

## Versioning
This project respects semantic versioning.

See http://semver.org/

## License

[![FOSSA Status](https://app.fossa.com/api/projects/git%2Bgithub.com%2Fxup6m6fu04%2Fbitwin-sdk-php.svg?type=large)](https://app.fossa.com/projects/git%2Bgithub.com%2Fxup6m6fu04%2Fbitwin-sdk-php?ref=badge_large)