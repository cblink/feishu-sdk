<?php

namespace Cblink\FeiShu\AccessToken;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class AccessTokenServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['app_access_token'] = function($app) {
            return new AppAccessToken($app);
        };

        $pimple['app_tenant_access_token'] = function($app) {
            return new AppTenantAccessToken($app);
        };
    }
}