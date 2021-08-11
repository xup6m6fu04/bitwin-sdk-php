<?php

namespace Xup6m6fu04\Bitwin\Apis;

use Xup6m6fu04\Bitwin\Response;

class MerchantWithdraw extends AbstractApi
{
    public function call(array $params = []): Response
    {
        $params['MerchantId'] = $this->getMerchantId();
        $params['Sign'] = $this->getSign($params);
        return $this->post($params);
    }
}