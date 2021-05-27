<?php

namespace Cblink\FeiShu\AccessToken;

use Cblink\FeiShu\Exceptions\InvalidArgumentException;

class AppAccessToken extends AbstractAccessToken
{
    public function getAccessToken($internal = true, $refresh = false)
    {
        if ($refresh) {
            $this->getCache()->delete($this->getAppAccessTokenCacheKey());
        }

        if (! $this->getCache()->has($this->getAppAccessTokenCacheKey())) {
            if ($internal) {
                $token = $this->getAppAccessTokenInternal();
            } else {
                $token = $this->getAppAccessToken();
            }

            $this->getCache()->set($this->getAppAccessTokenCacheKey(), $token->get('token'), $token->get('expire'));
        }

        return $this->getCache()->get($this->getAppAccessTokenCacheKey());
    }

    protected function getAppAccessTokenInternal()
    {
        $res = $this->httpPostJson('/auth/v3/app_access_token/internal/', [
            'app_id' => $this->app['config']['app_id'],
            'app_secret' => $this->app['config']['app_secret'],
        ]);

        return new Token($res['app_access_token'], $res['expire']);
    }

    protected function getAppAccessToken()
    {
        $res = $this->httpPostJson('/auth/v3/app_access_token/', [
            'app_id' => $this->app['config']['app_id'],
            'app_secret' => $this->app['config']['app_secret'],
            'app_ticket' => $this->getAppTicket(),
        ]);

        return new Token($res['app_access_token'], $res['expire']);
    }

    public function setAppTicket(string $ticket)
    {
        return $this->getCache()->set($this->getAppTicketCacheKey(), $ticket);
    }

    public function getAppTicket()
    {
        if ($token = $this->getCache()->get($this->getAppTicketCacheKey())) {
            return $token;
        }

        throw new InvalidArgumentException(sprintf('获取应用 %s 的 app_ticket 失败', $this->app['config']['app_id']));
    }

    public function getAppTicketCacheKey()
    {
        return 'app_ticket_'.$this->app['config']['app_id'];
    }

    public function getAppAccessTokenCacheKey()
    {
        return 'app_access_token_'.$this->app['config']['app_id'];
    }
}