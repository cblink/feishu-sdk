<?php

namespace Cblink\FeiShu;

use ZhenMu\Support\Http\AbstractRequestClient;

class Client extends AbstractRequestClient
{
    protected $baseUri = 'https://open.feishu.cn/open-apis/';

    public function __construct($app = null, $accessToken = null)
    {
        if (is_null($accessToken)) {
            $accessToken = $app ? $app->getHttpClientAccessToken() : null;
        }

        parent::__construct($app, $accessToken);
    }

    public function getResponseType()
    {
        return CastResponse::class;
    }
}