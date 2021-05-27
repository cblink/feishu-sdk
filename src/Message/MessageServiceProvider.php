<?php

namespace Cblink\FeiShu\Message;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class MessageServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['message'] = function($app) {
            return new Message($app);
        };
    }
}