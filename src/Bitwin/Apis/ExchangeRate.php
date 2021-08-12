<?php

namespace Xup6m6fu04\Bitwin\Apis;

use Xup6m6fu04\Bitwin\Response;

class ExchangeRate extends AbstractApi
{
    /**
     * @param array $params
     * @return \Xup6m6fu04\Bitwin\Response
     */
    public function call(array $params = []): Response
    {
        $params['MerchantId'] = $this->getMerchantId();
        $params['Sign'] = $this->getSign($params);
        return $this->post($params);
    }
}