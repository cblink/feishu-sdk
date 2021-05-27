<?php

namespace Cblink\FeiShu\AccessToken;

use Cblink\FeiShu\Client;
use Psr\Http\Message\RequestInterface;
use ZhenMu\Support\Contracts\AccessToken;
use ZhenMu\Support\Traits\InteractsWithCache;

abstract class AbstractAccessToken extends Client implements AccessToken
{
    use InteractsWithCache;

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