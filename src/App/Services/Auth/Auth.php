<?php

namespace App\Services\Auth;

use App\Controllers\User\UserController;
use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Database\Capsule\Manager;
use Slim\Collection;
use Slim\Http\Request;
use DateTime;
use Tuupola\Middleware\JwtAuthentication;

class Auth
{
    const IDENTIFIER = 'username';

    /** @var \Illuminate\Database\Capsule\Manager */
    protected $db;

    /**
     * Auth constructor.
     * @param Illuminate\Database\Capsule\Manager $db
     * @param Slim\Collection $appConfig
     */
    public function __construct(Manager $db, Collection $appConfig)
    {
        $this->db = $db;
        $this->appConfig = $appConfig;
    }

    /**
     *
     * Generate a new JWT token
     *
     * @param User $user
     * @return string
     */
    public function generateToken(User $user)
    {
        $now = new DateTime();
        $expiration_time = new DateTime("now +2 hours");

        $payload = [
            "iat" => $now->getTimeStamp(),
            "exp" => $expiration_time->getTimeStamp(),
            "jti" => base64_encode(random_bytes(16)),
            "iss" => $this->appConfig['app']['url'],
            "sub" => $user->{self::IDENTIFIER}
        ];

        $secret = $this->appConfig['jwt']['secret'];

        $token = JWT::encode($payload, $secret, "HS256");

        return $token;
    }

    /**
     *
     * Check user existence by email and password
     *
     * @param $email
     * @param $password
     * @return bool
     */
    public function checkUser($email, $password)
    {
        if (!$user = User::where('email', $email)->first()) {
            return false;
        }

        if (password_verify($password, $user->password)) {
            return $user;
        }

        return false;
    }

    /**
     *
     *  Request user by JWT token from Reqiest
     *
     * @param Request $request
     * @return User | null
     */
    public function requestUser(Request $request)
    {
        if ($token = $request->getAttribute('token')) {
            return User::where(static::IDENTIFIER, $token['sub'])->first();
        }
    }
}