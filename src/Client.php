<?php

namespace Cblink\FeiShu;

use Cblink\FeiShu\AccessToken\AbstractAccessToken;
use ZhenMu\Support\Contracts\AccessToken;
use ZhenMu\Support\Http\AbstractRequestClient;

class Client extends AbstractRequestClient
{
    protected $baseUri = 'https://open.feishu.cn/open-apis/';

    public function __construct($app = null, $accessToken = null)
    {
        if (is_null($accessToken)) {
            if (!$this instanceof AbstractAccessToken) {
                $accessToken = $app ? $app->getHttpClientAccessToken() : null;
            }
        }

        parent::__construct($app, $accessToken);
    }

    public function getResponseType()
    {
        return CastResponse::class;
    }
}