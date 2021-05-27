<?php

namespace Cblink\FeiShu\AccessToken;

class AppTenantAccessToken extends AppAccessToken
{
    public function getAccessToken($internal = true, $refresh = false)
    {
        if ($refresh) {
            $this->getCache()->delete($this->getAppTenantAccessTokenCacheKey());
        }

        if (! $this->getCache()->has($this->getAppTenantAccessTokenCacheKey())) {
            if ($internal) {
                $token = $this->getTenantAccessTokenInternal();
            } else {
                $token = $this->getTenantAccessToken();
            }

            $this->getCache()->set($this->getAppTenantAccessTokenCacheKey(), $token->get('token'), $token->get('expire'));
        }

        return $this->getCache()->get($this->getAppTenantAccessTokenCacheKey());
    }

    protected function getTenantAccessTokenInternal()
    {
        $res = $this->httpPostJson('/auth/v3/tenant_access_token/internal/', [
            'app_id' => $this->app['config']['app_id'],
            'app_secret' => $this->app['config']['app_secret'],
        ]);

        return new Token($res['tenant_access_token'], $res['expire']);
    }

    /**
     * 获取应用的 tenant 级别 token 权限
     *
     * @return Token
     */
    protected function getTenantAccessToken()
    {
        $res = $this->httpPostJson('/auth/v3/tenant_access_token/', [
            'tenant_key' => $this->app['config']['tenant_key'],
            'app_access_token' => parent::getToken(),
        ]);

        return new Token($res['tenant_access_token'], $res['expire']);
    }

    public function getAppTenantAccessTokenCacheKey()
    {
        return 'app_tenant_access_token_'.$this->app['config']['app_id'];
    }
}