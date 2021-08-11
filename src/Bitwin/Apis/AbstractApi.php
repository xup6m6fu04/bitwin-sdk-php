<?php

namespace Xup6m6fu04\Bitwin\Apis;

use Xup6m6fu04\Bitwin\Exception\BitwinSDKException;
use Xup6m6fu04\Bitwin\HTTPClient;
use Xup6m6fu04\Bitwin\Response;

abstract class AbstractApi
{
    /** @var string */
    private $merchantId;
    /** @var string */
    private $signKey;
    /** @var string */
    private $url;
    /** @var HTTPClient */
    private HTTPClient $httpClient;

    /**
     * @throws BitwinSDKException
     */
    public function __construct(HTTPClient $httpClient = null, $url = null, $signKey = null, $merchantId = null)
    {
        if (is_null($httpClient)) {
            throw new BitwinSdkException('httpClient must be set when call APIs.');
        }

        if (is_null($url)) {
            throw new BitwinSdkException('endpointBase must be set when call APIs.');
        }

        if (is_null($signKey)) {
            throw new BitwinSdkException('signKey must be set when call APIs.');
        }

        if (is_null($merchantId)) {
            throw new BitwinSdkException('merchantId must be set when call APIs.');
        }

        $this->merchantId = $merchantId;
        $this->signKey = $signKey;
        $this->httpClient = $httpClient;
        $this->url = $url;
    }

    public function getMerchantId()
    {
        return $this->merchantId;
    }

    public function getSign($args): string
    {
        ksort($args);
        $args = array_filter($args);
        $text = implode(',', $args) . ',' . $this->signKey;
        return strtoupper(md5($text));
    }

    public function post($args): Response
    {
        return $this->httpClient->post($this->url, $args);
    }
}