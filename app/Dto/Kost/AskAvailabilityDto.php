<?php

namespace App\Dto\Kost;

use App\Dto\DataTransferObject;

class AskAvailabilityDto extends DataTransferObject
{
    public int $id;
    public int $user_id;
}