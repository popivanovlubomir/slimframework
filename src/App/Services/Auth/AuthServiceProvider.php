<?php

namespace App\Services\Auth;


use Interop\Container\ContainerInterface;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class AuthServiceProvider implements ServiceProviderInterface
{
    /**
     *
     * Register services on the given container
     *
     * @param Container $pimple
     */
    public function register(Container $pimple)
    {
        $pimple['auth'] = function(ContainerInterface $c) {
            return new Auth($c->get('db'), $c->get('settings'));
        };
    }
}