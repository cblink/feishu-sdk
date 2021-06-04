<?php

namespace Cblink\FeiShu\Serve;

use Cblink\FeiShu\ServerGuard;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServeServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['serve'] = function ($app) {
            return new ServerGuard($app);
        };
    }
}