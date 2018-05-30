<?php

namespace App\Controllers\Auth;

use Interop\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class LoginController
{

    /** @var \Illuminate\Database\Capsule\Manager */
    protected $db;

    /** @var \App\Services\Auth\Auth */
    protected $auth;

    /**
     * LoginController constructor.
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

    /**
     *
     * Return token after successful login
     *
     * @param Request $request
     * @param Response $response
     * @return static
     */
    public function login(Request $request, Response $response)
    {
        $userParams = $request->getParam('user');

        if ($user = $this->auth->checkUser($userParams['email'], $userParams['password'])) {
            $user->token = $this->auth->generateToken($user);
            $user->saveOrFail();

            return $response->withJson(['AccessToken' => $user->token]);
        }

        return $response->withJson(['errors' => ['email or password' => ['is invalid']]], 422);
    }

}

