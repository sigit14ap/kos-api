<?php

namespace App\Services\Auth\Interfaces;

use App\Models\User;
use App\Dto\Auth\RegisterDto;

interface AuthServiceInterface
{
    /**
     * Register user
     * @param   RegisterDto $attribute
     * @return  User
     */
    public function register(RegisterDto $attribute) : User;
}