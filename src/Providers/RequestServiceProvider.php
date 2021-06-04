<?php

namespace Cblink\FeiShu\Providers;

use Cblink\FeiShu\Encryptor;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class RequestServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['encryptor'] = function ($app) {
            return new Encryptor($app->config['event_encrypt_key']);
        };

        $pimple['request'] = function ($app) {
            return Request::createFromGlobals();
        };
    }
}