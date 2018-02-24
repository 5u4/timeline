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
     * @param string $name
     * @param string $password
     * @return User
     */
    public function create(string $name, string $password): User
    {
        $user = new User();

        $user->name = $name;
        $user->password = bcrypt($password);

        $user->save();

        return $user;
    }
}