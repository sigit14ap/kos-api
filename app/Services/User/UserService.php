<?php

namespace App\Services\User;

use App\Services\User\Interfaces\UserServiceInterface;
use App\Models\User;
use App\Dto\User\AddCreditDto;

class UserService implements UserServiceInterface
{
    /**
     * Add credit user
     * @return  bool
     */
    public function addCredit() : bool
    {
        $users = User::whereIn('user_type', ['regular', 'premium'])->get();

        foreach($users as $row){
            
            $add = $row->user_type == 'regular' ? 20 : 40;

            $row->update([
                'credit' => $row->credit + $add
            ]);
        }
        
        return true;
    }
}