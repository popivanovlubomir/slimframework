<?php

namespace App\Services\Database;


use Illuminate\Database\Capsule\Manager;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class EloquentServiceProvider implements ServiceProviderInterface {
    /**
     *
     * Register services on the given container
     *
     * @param Container $pimple
     * @return Manager
     */
    public function register(Container $pimple)
    {
        $capsule = new Manager();
        $config = $pimple['settings']['db'];

        $capsule->addConnection([
            'driver'    => $config['driver'],
            'host'      => $config['host'],
            'database'  => $config['database'],
            'username'  => $config['username'],
            'password'  => $config['password'],
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        $pimple['db'] = function(Container $c) use ($capsule) {
            return $capsule;
        };
    }
}