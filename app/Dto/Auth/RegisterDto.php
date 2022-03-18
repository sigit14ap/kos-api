<?php

namespace App\Dto\Auth;

use App\Dto\DataTransferObject;

class RegisterDto extends DataTransferObject
{
    public string $name;
    public string $email;
    public string $password;
    public string $user_type;
}
