<?php

namespace App\Dto\Kost;

use App\Dto\DataTransferObject;

class SearchDto extends DataTransferObject
{
    public int $per_page;
    public ?string $search;
    public ?int $min_price;
    public ?int $max_price;
    public string $sort_price = 'ASC';
}