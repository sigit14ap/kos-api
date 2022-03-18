<?php

namespace App\Dto\Kost;

use App\Dto\DataTransferObject;

class DeleteDto extends DataTransferObject
{
    public int $id;
    public int $user_id;
}