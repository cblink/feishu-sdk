<?php

namespace Cblink\FeiShu\Contact;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ContactServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['user'] = function($app) {
            return new User($app);
        };
        $pimple['department'] = function($app) {
            return new Department($app);
        };
    }
}