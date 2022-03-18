<?php

namespace App\Services\Auth;

use App\Services\Auth\Interfaces\AuthServiceInterface;
use App\Models\User;
use App\Dto\Auth\RegisterDto;

class AuthService implements AuthServiceInterface
{
    /**
     * Register user
     * @param   RegisterDto $attribute
     * @return  User
     */
    public function register(RegisterDto $attribute) : User
    {
        return User::create([
            'name'      =>  $attribute->name,
            'email'     =>  $attribute->email,
            'password'  =>  $attribute->password,
            'user_type' =>  $attribute->user_type
        ]);
    }
}