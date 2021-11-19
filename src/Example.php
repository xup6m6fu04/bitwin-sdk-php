<?php

require "vendor/autoload.php";

use Xup6m6fu04\Bitwin;
use Xup6m6fu04\Bitwin\Exception\BitwinSDKException;
use Xup6m6fu04\Bitwin\HTTPClient\GuzzleHTTPClient;

$c = new Example();

/**
 * 以下建議一次調試一個，並查看輸出。
 * 將註解移除即可。
 * 記得調換 merchant_id & sign_key 以及運行環境
 */

/*建立付款訂單*/
//$c->createCryptoPayOrder();
/*查詢付款訂單*/
//$c->queryCryptoPayOrder();
/*建立商戶出款單*/
//$c->merchantWithdraw();
/*查詢商戶出款單*/
$c->queryMerchantWithdraw();
/*查詢建議匯率*/
//$c->exchangeRate();
/*BITWIN 會員錢包綁定*/

//$c->buildRelationUser();

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
            'merchant_id' => 'yozero',
            'sign_key' => '78BE61C994B4ECD4C7E3BC1C1AE86703',
            'access_key' => '1d006af9-45ea-11ec-b215-029e914f4f74',
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
                'MerchantRMB' => '45.38',
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

    /**
     * Query Crypto Pay Order
     * 查詢付款訂單
     * 查询付款订单
     */
    public function queryCryptoPayOrder()
    {
        try {
            $args = [
                'MerchantOrderId' => 'YOZERO_ORDER_01',
                'OrderId' => '53298248131218784',
                'TimeStamp' => '1628664587'
            ];
            $result = $this->bitwin->api('QueryCryptoPayOrder')->call($args);
            print_r($result->getJSONDecodedBody());
            /**
             * Successfully printed the result (PENDING)
             * Array
             * (
             *     [OrderId] => 53298248131218784
             *     [MerchantOrderId] => YOZERO_ORDER_01
             *     [MerchantUserId] => YOZERO_USER_01
             *     [OrderDescription] => YOZERO_DESC_01
             *     [Symbol] => USDT_ERC20
             *     [Amount] => 700000000
             *     [RealAmount] => 700000000
             *     [MerchantRMB] => 45.38
             *     [ExchangeRMB] => 45.85
             *     [OrderStatus] => PENDING
             *     [CallBackUrl] => https://test.com/api/callback
             *     [ReturnCode] => 200
             *     [ReturnMessage] =>
             *     [Sign] => 79F79283D033AF0485B91FABCA6F5F81
             * )
             */
            /**
             * Successfully printed the result (SUCCESS)
             * Array
             * (
             *     [OrderId] => 53298248131218784
             *     [MerchantOrderId] => YOZERO_ORDER_01
             *     [MerchantUserId] => YOZERO_USER_01
             *     [OrderDescription] => YOZERO_DESC_01
             *     [Symbol] => USDT_ERC20
             *     [Amount] => 700000000
             *     [RealAmount] => 700000000
             *     [MerchantRMB] => 45.38
             *     [ExchangeRMB] => 45.85
             *     [OrderStatus] => SUCCESS
             *     [CallBackUrl] => https://test.com/api/callback
             *     [ReturnCode] => 200
             *     [ReturnMessage] =>
             *     [Sign] => ED8B4222F79429E05B5F4E2F0BC49944
             * )
             */
            /**
             * If users paid, your callback server will receive JSON like
             * array (
             *  'MerchantId' => 'your_merchant_id',
             *  'MerchantOrderId' => 'YOZERO_ORDER_01',
             *  'OrderId' => '53298248131218784',
             *  'Symbol' => 'USDT_ERC20',
             *  'Amount' => '700000000',
             *  'PayAmount' => '700000000',
             *  'MerchantRMB' => '45.38',
             *  'ExchangeRMB' => '45.85',
             *  'PayUnixTimestamp' => 1628667177,
             *  'Sign' => '4B8CEE2EED8A86D1A2C47752E11FA818',
             *  )
             */
        } catch (BitwinSDKException | Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Merchant Withdraw
     * 建立商戶出款單
     * 建立商户出款单
     */
    public function merchantWithdraw()
    {
        try {
            $args = [
                'MerchantUserId' => 'YOZERO_USER_01',
                'MerchantWithdrawId' => 'YOZERO_WITHDRAW_01',
                'UserWallet' => '0x875EDa094F03Ed4c93adb3dbb77913F860dC888f',
                'Amount' => '1000000000', // 10 USDT
                'MerchantRMB' => '64.81',
                'Symbol' => 'USDT_ERC20',
                'CallBackUrl' => 'https://test.com/api/callback',
                'TimeStamp' => '1628664587'
            ];
            $result = $this->bitwin->api('MerchantWithdraw')->call($args);
            print_r($result->getJSONDecodedBody());
            /**
             * Successfully printed the result
             * Array
             * (
             *     [WithdrawId] => 53304076324244832
             *     [MerchantWithdrawId] => YOZERO_WITHDRAW_01
             *     [ReturnCode] => 200
             *     [ReturnMessage] =>
             *     [Sign] => 1DD42670319C41ABF0986BD21DB1ADB1
             * )
             */
        } catch (BitwinSDKException | Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Query Merchant Withdraw
     * 查詢商戶出款單
     * 查询商户出款单
     */
    public function queryMerchantWithdraw()
    {
        try {
            $args = [
                'MerchantWithdrawId' => 'YOZERO_WITHDRAW_0000001',
                'WithdrawId' => '53192080311396704',
                'TimeStamp' => '1628664587'
            ];
            $result = $this->bitwin->api('QueryMerchantWithdraw')->call($args);
            print_r($result->getJSONDecodedBody());
            /**
             * Successfully printed the result (PENDING)
             * Array
             * (
             *     [MerchantUserId] => YOZERO_USER_01
             *     [UserWallet] => 0x875EDa094F03Ed4c93adb3dbb77913F860dC888f
             *     [WithdrawId] => 53304076324244832
             *     [MerchantWithdrawId] => YOZERO_WITHDRAW_01
             *     [Symbol] => USDT_ERC20
             *     [Amount] => 1000000000
             *     [MerchantRMB] => 64.81
             *     [ExchangeRMB] => 68.00
             *     [Status] => PENDING
             *     [ReturnCode] => 200
             *     [ReturnMessage] =>
             *     [Sign] => 23821A64B674B01D2D35CF0DCC41CCB3
             * )
             */
            /**
             * Successfully printed the result (SUCCESS)
             * Array
             * (
             *     [MerchantUserId] => YOZERO_USER_01
             *     [UserWallet] => 0x875EDa094F03Ed4c93adb3dbb77913F860dC888f
             *     [WithdrawId] => 53304076324244832
             *     [MerchantWithdrawId] => YOZERO_WITHDRAW_01
             *     [Symbol] => USDT_ERC20
             *     [Amount] => 1000000000
             *     [MerchantRMB] => 64.81
             *     [ExchangeRMB] => 68.00
             *     [Status] => SUCCESS
             *     [WithdrawDateTime] => 1628671968
             *     [ApprovedDateTime] => 1628671529
             *     [ReturnCode] => 200
             *     [ReturnMessage] =>
             *     [Sign] => B94D0315F82ABBA5B5003C3B97B3B067
             * )
             */
            /**
             * If withdraw success, your callback server will receive JSON like
             * {
             *    "MerchantId": "your_merchant_id",
             *    "MerchantUserId": "YOZERO_USER_01",
             *    "MerchantWithdrawId": "YOZERO_WITHDRAW_01",
             *    "UserWallet": "x875EDa094F03Ed4c93adb3dbb77913F860dC888f",
             *    "WithdrawId": "53304076324244832",
             *    "WithdrawAmount": "1000000000",
             *    "MerchantRMB": "64.81",
             *    "ExchangeRMB": "68.00",
             *    "Symbol": "USDT_ERC20",
             *    "ReplyDateTime": 1628671968,
             *    "Sign": "B8197B5498E4BB6289CBFD39AE282AF0"
             * }
             */
        } catch (BitwinSDKException | Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Exchange Rate
     * 查詢建議匯率
     * 查询建议汇率
     */
    public function exchangeRate()
    {
        try {
            $args = [
                'Symbol' => 'USDT_ERC20'
            ];
            $result = $this->bitwin->api('ExchangeRate')->call($args);
            print_r($result->getJSONDecodedBody());
            /**
             * Successfully printed the result (PENDING)
             * Array
             * (
             *     [RMBRate] => 6.55
             *     [RMBBuyRate] => 6.80
             *     [ReturnCode] => 200
             *     [ReturnMessage] =>
             * )
             */
        } catch (BitwinSDKException | Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Build Relation User
     * BITWIN 會員錢包綁定
     * BITWIN 会员钱包绑定
     */
    public function buildRelationUser()
    {
        try {
            $args = [
                'MerchantUserId' => 'YOZERO_USER_01',
                'CallBackUrl' => 'https://test.com/api/callback',
                'TimeStamp' => '1628664587'
            ];
            $result = $this->bitwin->api('BuildRelationUser')->call($args);
            print_r($result->getJSONDecodedBody());
            /**
             * Successfully printed the result
             * Array
             * (
             *     [QrcodeData] => BITWIN$eyJhY3Rpb24iOiJtb2JpbGUvdjMvdXNlci9iaW5kIiwiZGF0YSI6eyJuYW1lIjoiNDRFNkYyMDJEOTU2NDhDNTdBOEYwMTAyREMyQjlEREUiLCJjb2RlIjoiM0xEVkYiLCJtZXJjaGFudF9uYW1lIjoieW96ZXJvIn19
             *     [QrcodeImageUrl] => https://stage-api.bitwin.ai/web/v3/bind/user/44E6F202D95648C57A8F0102DC2B9DDE
             *     [ReturnCode] => 200
             *     [ReturnMessage] =>
             *     [Sign] => C00CA273DC3CA6CBDA81E2EB2B12B5D5
             * )
             */
            /**
             * After user scan, your callback server will receive JSON like
             * {
             *    "MerchantId": "your_merchant_id",
             *    "MerchantUserId": "YOZERO_USER_01",
             *    "UserName": "48847933077253904",
             *    "BTC": "2My4ttAncyVKbAQWwAMLsG7JCMif3KkpHBC",
             *    "ETH": "0xe4f3Ad1005ac2FbD22f7F22871A8Ea1d688866a0",
             *    "USDT_ERC20": "0x7F8FAe2d400cD767d4184638eD296DBc44F218Bb",
             *    "USDT_TRC20": "TYGzJX3tyDy81eQGGw92US821LiykuHPFi",
             *    "USDT_BEP20": "0x84e6B02d0223c004bc350F481038371Cfd7e4512",
             *    "Sign": "BE5756882B97BAADB8AAF86A49441FCA"
             * }
             */
        } catch (BitwinSDKException | Exception $e) {
            echo $e->getMessage();
        }
    }
}



