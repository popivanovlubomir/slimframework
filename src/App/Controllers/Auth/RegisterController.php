<?php

namespace App\Controllers\Auth;

use App\Models\User;
use Interop\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class RegisterController
{

    /** @var \Illuminate\Database\Capsule\Manager */
    protected $db;

    /** @var \App\Services\Auth\Auth */
    protected $auth;

    /**
     * RegisterController constructor.
     *
     * @param ContainerInterface $container
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __construct(ContainerInterface $container)
    {
        $this->auth = $container->get('auth');
        $this->db = $container->get('db');
    }

    public function register(Request $request, Response $response)
    {
         /* @TODO add validations */
        $userParams = $request->getParam('user');

        $user = new User($userParams);
        $user->token = $this->auth->generateToken($user);
        $user->password = password_hash($userParams['password'], PASSWORD_DEFAULT);
        $user->saveOrFail();

        return $response->withJson([
            'user' => $user
        ]);
    }
}

