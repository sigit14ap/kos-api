<?php

namespace App\Dto\Kost;

use App\Dto\DataTransferObject;

class UpdateDto extends DataTransferObject
{
    public int $id;
    public int $user_id;
    public string $name;
    public string $location;
    public int $price;
}