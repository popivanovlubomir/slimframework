<?php

use App\Controllers\Auth\RegisterController;
use App\Controllers\Auth\LoginController;
use App\Controllers\User\UserController;
use Slim\Http\Request;
use Slim\Http\Response;

// Routes
$app->group('/api',
    function() {
        $jwtMiddleware = $this->getContainer()->get('jwt');

        // Auth routes
        $this->post('/users', RegisterController::class.':register')->setName('auth.register');
        $this->post('/users/login', LoginController::class.':login')->setName('auth.login');
        //show user
        $this->get('/user', UserController::class.':show')->add($jwtMiddleware)->setName('user.show');
    }
);

$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});
