<?php

namespace Cblink\FeiShu\Providers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

class EventDispatcherServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['events'] = function ($app) {
            $dispatcher =  new EventDispatcher();

            foreach ($app->config['events']['listen'] ?? [] as $event => $listeners) {
                foreach ($listeners as $listener) {
                    $dispatcher->addListener($event, $listener);
                }
            }

            return $dispatcher;
        };
    }
}