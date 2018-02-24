<?php

namespace App\Http\Services;

use App\Models\User;

/**
 * Class UserService
 * @package App\Service
 */
class UserService
{
    /**
     * @param string $username
     * @param string $password
     * @return User
     */
    public function create(string $username, string $password): User
    {
        $user = new User();

        $user->username = $username;
        $user->password = bcrypt($password);
        $user->api_token = str_random(User::API_TOKEN_LENGTH);

        $user->save();

        return $user;
    }
}