<?php

namespace App\Dto\Kost;

use App\Dto\DataTransferObject;

class FindDto extends DataTransferObject
{
    public int $id;
    public int $user_id;
}