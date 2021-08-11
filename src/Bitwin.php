<?php

namespace Xup6m6fu04;

use Xup6m6fu04\Bitwin\Apis\AbstractApi;
use Xup6m6fu04\Bitwin\Apis\BuildRelationUser;
use Xup6m6fu04\Bitwin\Apis\CreateCryptoPayOrder;
use Xup6m6fu04\Bitwin\Apis\ExchangeRate;
use Xup6m6fu04\Bitwin\Apis\MerchantWithdraw;
use Xup6m6fu04\Bitwin\Apis\QueryCryptoPayOrder;
use Xup6m6fu04\Bitwin\Apis\QueryMerchantWithdraw;
use Xup6m6fu04\Bitwin\Exception\BitwinSDKException;
use Xup6m6fu04\Bitwin\Exception\InvalidArgumentException;
use Xup6m6fu04\Bitwin\HTTPClient;

class Bitwin
{
    const TEST_API_BASE_URL = "https://stage-api.bitwin.ai/api/v3";
    const PROD_API_BASE_URL = "https://api.bitwin.ai/api/v3";

    /** @var string */
    private $merchantId;
    /** @var string */
    private $signKey;
    /** @var string */
    private string $endpointBase;
    /** @var HTTPClient */
    private HTTPClient $httpClient;

    /**
     * @throws BitwinSDKException
     */
    public function __construct(HTTPClient $httpClient, array $args = [])
    {
        $this->httpClient = $httpClient;
        $args = array_merge([
            'merchant_id' => '',
            'sign_key' => '',
            'is_prod_environment' => false,
        ], $args);

        if (!$args['merchant_id']) {
            throw new BitwinSDKException('Required "merchant_id"');
        }

        if (!$args['sign_key']) {
            throw new BitwinSDKException('Required "sign_key"');
        }

        $this->merchantId = $args['merchant_id'];
        $this->signKey = $args['sign_key'];
        $this->endpointBase = $args['is_prod_environment'] === true ? static::PROD_API_BASE_URL : static::TEST_API_BASE_URL;
    }

    /**
     * @throws BitwinSDKException
     */
    public function api($name)
    {
        switch ($name) {
            case 'CreateCryptoPayOrder':
                $url = $this->endpointBase . '/CreateCryptoPayOrder';
                $api = new CreateCryptoPayOrder($this->httpClient, $url, $this->signKey, $this->merchantId);
                break;
            case 'QueryCryptoPayOrder':
                $url = $this->endpointBase . '/QueryCryptoPayOrder';
                $api = new QueryCryptoPayOrder($this->httpClient, $url, $this->signKey, $this->merchantId);
                break;
            case 'MerchantWithdraw':
                $url = $this->endpointBase . '/MerchantWithdraw';
                $api = new MerchantWithdraw($this->httpClient, $url, $this->signKey, $this->merchantId);
                break;
            case 'QueryMerchantWithdraw':
                $url = $this->endpointBase . '/QueryMerchantWithdraw';
                $api = new QueryMerchantWithdraw($this->httpClient, $url, $this->signKey, $this->merchantId);
                break;
            case 'ExchangeRate':
                $url = $this->endpointBase . '/ExchangeRate';
                $api = new ExchangeRate($this->httpClient, $url, $this->signKey, $this->merchantId);
                break;
            case 'BuildRelationUser':
                $url = $this->endpointBase . '/BuildRelationUser';
                $api = new BuildRelationUser($this->httpClient, $url, $this->signKey, $this->merchantId);
                break;
            default:
                throw new InvalidArgumentException(sprintf('Undefined api instance called: "%s"', $name));
        }
        return $api;
    }

    public function getClient(): HTTPClient
    {
        return $this->httpClient;
    }
}