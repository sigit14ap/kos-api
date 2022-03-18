<?php

namespace App\Dto\Kost;

use App\Dto\DataTransferObject;

class StoreDto extends DataTransferObject
{
    public int $user_id;
    public string $name;
    public string $location;
    public int $price;
}