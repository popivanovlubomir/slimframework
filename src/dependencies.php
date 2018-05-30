<?php
// DIC configuration

$container = $app->getContainer();

//register Eloquent service provider
$container->register(new App\Services\Database\EloquentServiceProvider());

//register Auth service provider
$container->register(new App\Services\Auth\AuthServiceProvider());

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

// Jwt middleware
$container['jwt'] = function ($c) {
    $jws_settings = $c->get('settings')['jwt'];

    return new Tuupola\Middleware\JwtAuthentication($jws_settings);
};