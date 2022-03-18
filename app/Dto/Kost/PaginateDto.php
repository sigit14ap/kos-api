<?php

namespace App\Dto\Kost;

use App\Dto\DataTransferObject;

class PaginateDto extends DataTransferObject
{
    public int $per_page;
    public int $user_id;
}