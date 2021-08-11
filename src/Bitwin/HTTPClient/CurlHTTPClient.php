<?php

namespace Xup6m6fu04\Bitwin\HTTPClient;

use Xup6m6fu04\Bitwin\Exception\CurlExecutionException;
use Xup6m6fu04\Bitwin\HTTPClient;
use Xup6m6fu04\Bitwin\Response;

/**
 * Class CurlHTTPClient.
 *
 * A HTTPClient that uses cURL.
 *
 * @package Xup6m6fu04\Bitwin\HTTPClient
 */
class CurlHTTPClient implements HTTPClient
{
    /** @var array */
    private array $defaultHeaders;
    /** @var int */
    private int $timeout;
    /** @var int */
    private int $connectTimeout;

    /**
     * CurlHTTPClient constructor.
     */
    public function __construct()
    {
        $this->defaultHeaders = [
            "Content-Type: application/json"
        ];

        $this->timeout = 30;
        $this->connectTimeout = 30;
    }

    /**
     * Sends POST request to Bitwin merchant API.
     *
     * @param string $url Request URL.
     * @param array $data Request body or resource path.
     * @param array|null $headers Request headers.
     * @return Response Response of API request.
     * @throws CurlExecutionException
     */
    public function post(string $url, array $data, array $headers = null): Response
    {
        $headers = is_null($headers) ? ['Content-Type: application/json; charset=utf-8'] : $headers;
        return $this->sendRequest('POST', $url, $headers, $data);
    }

    /**
     * set curl timeout second
     *
     * @param int $timeout timeout(sec)
     */
    public function setTimeout(int $timeout)
    {
        $this->timeout = $timeout;
    }

    /**
     * set curl connect timeout second
     *
     * @param int $connectTimeout connectTimeout(sec)
     */
    public function setConnectTimeout(int $connectTimeout)
    {
        $this->connectTimeout = $connectTimeout;
    }

    /**
     * @param string $method
     * @param array $headers
     * @param array|string|null $reqBody
     * @return array cUrl options
     */
    private function getOptions(string $method, array $headers, $reqBody): array
    {
        $options = [
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_BINARYTRANSFER => true,
            CURLOPT_HEADER => true,
        ];
        if ($method === 'POST') {
            if (is_null($reqBody)) {
                $options[CURLOPT_HTTPHEADER][] = 'Content-Length: 0';
            } else {
                if (isset($reqBody['__file']) && isset($reqBody['__type'])) {
                    $options[CURLOPT_PUT] = true;
                    $options[CURLOPT_INFILE] = fopen($reqBody['__file'], 'r');
                    $options[CURLOPT_INFILESIZE] = filesize($reqBody['__file']);
                } elseif (in_array('Content-Type: application/x-www-form-urlencoded', $headers)) {
                    $options[CURLOPT_POST] = true;
                    $options[CURLOPT_POSTFIELDS] = http_build_query($reqBody);
                } elseif (in_array('Content-Type: multipart/form-data', $headers)) {
                    $options[CURLOPT_POST] = true;
                    $options[CURLOPT_POSTFIELDS] = $reqBody;
                } elseif (!empty($reqBody)) {
                    $options[CURLOPT_POST] = true;
                    $options[CURLOPT_POSTFIELDS] = json_encode($reqBody);
                } else {
                    $options[CURLOPT_POST] = true;
                    $options[CURLOPT_POSTFIELDS] = $reqBody;
                }
            }
        }
        if ($method === 'PUT') {
            if (in_array('Content-Type: multipart/form-data', $headers)) {
                $options[CURLOPT_POSTFIELDS] = $reqBody;
            } elseif (!empty($reqBody)) {
                $options[CURLOPT_POSTFIELDS] = json_encode($reqBody);
            } else {
                $options[CURLOPT_POSTFIELDS] = $reqBody;
            }
        }
        if (!is_null($this->timeout)) {
            $options[CURLOPT_TIMEOUT] = $this->timeout;
        }
        if (!is_null($this->connectTimeout)) {
            $options[CURLOPT_CONNECTTIMEOUT] = $this->connectTimeout;
        }
        return $options;
    }

    /**
     * @param string $method
     * @param string $url
     * @param array $additionalHeader
     * @param string|array|null $reqBody
     * @return Response
     * @throws CurlExecutionException
     */
    private function sendRequest(string $method, string $url, array $additionalHeader, $reqBody = null): Response
    {
        $curl = new Curl($url);

        $headers = array_merge($this->defaultHeaders, $additionalHeader);

        $options = $this->getOptions($method, $headers, $reqBody);
        $curl->setoptArray($options);

        $result = $curl->exec();

        if ($curl->errno()) {
            throw new CurlExecutionException($curl->error());
        }

        $info = $curl->getinfo();
        $httpStatus = $info['http_code'];

        $responseHeaderSize = $info['header_size'];

        $responseHeaderStr = substr($result, 0, $responseHeaderSize);
        $responseHeaders = [];
        foreach (explode("\r\n", $responseHeaderStr) as $responseHeader) {
            $kv = explode(':', $responseHeader, 2);
            if (count($kv) === 2) {
                $responseHeaders[$kv[0]] = trim($kv[1]);
            }
        }

        $body = substr($result, $responseHeaderSize);

        if (isset($options[CURLOPT_INFILE])) {
            fclose($options[CURLOPT_INFILE]);
        }

        return new Response($httpStatus, $body, $responseHeaders);
    }
}
