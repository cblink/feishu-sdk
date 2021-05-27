<?php

namespace Cblink\FeiShu\WebhookBot;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class WebhookBotServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['webhook_bot'] = function($app) {
            return new WebhookBot($app);
        };
    }
}