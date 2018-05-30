<?php

namespace App\Controllers\User;

use Interop\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class UserController
{
    /** @var \Illuminate\Database\Capsule\Manager */
    protected $db;

    /** @var \App\Services\Auth\Auth */
    protected $auth;

    /**
     * UserController constructor.
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
     * Show user data by Request token
     *
     * @param Request $request
     * @param Response $response
     * @return static
     */
    public function show(Request $request, Response $response)
    {
        if ($user = $this->auth->requestUser($request)) {
            return $response->withJson(['user' => $user]);
        }

        return $response->withJson(['errors' => ['Token' => ['is invalid']]], 422);
    }

}