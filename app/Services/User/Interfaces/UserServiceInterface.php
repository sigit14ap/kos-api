<?php

namespace App\Services\User\Interfaces;

use App\Models\User;
use App\Dto\User\AddCreditDto;

interface UserServiceInterface
{
    /**
     * Add credit user
     * @return  bool
     */
    public function addCredit() : bool;
}