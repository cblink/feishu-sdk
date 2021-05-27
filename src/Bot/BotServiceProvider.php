<?php

namespace Cblink\FeiShu\Bot;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class BotServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['bot'] = function($app) {
            return new Bot($app);
        };
    }
}