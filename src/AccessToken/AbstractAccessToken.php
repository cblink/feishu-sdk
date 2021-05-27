<?php

namespace Cblink\FeiShu\AccessToken;

use Cblink\FeiShu\Application;
use Cblink\FeiShu\CastResponse;
use Psr\Http\Message\RequestInterface;
use ZhenMu\Support\Contracts\AccessToken;
use ZhenMu\Support\Http\Request;
use ZhenMu\Support\Traits\InteractsWithCache;

abstract class AbstractAccessToken extends Request implements AccessToken
{
    use InteractsWithCache;

    protected $app;

    protected $baseUri = 'https://open.feishu.cn/open-apis/';

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function getResponseType()
    {
        return CastResponse::class;
    }

    public function request($url, $method = 'GET', $options = [])
    {
        $response = parent::request($url, $method, $options);

        return $response->toArray();
    }

    public function applyToRequest(RequestInterface $request, array $options)
    {
        return $request->withAddedHeader('Authorization', sprintf('Bearer %s', $this->getToken()));
    }

    public function refresh()
    {
        return $this->getToken(true);
    }

    public function getToken($refresh = false)
    {
        return $this->getAccessToken(true, $refresh);
    }

    abstract public function getAccessToken($internal = true, $refresh = false);
}