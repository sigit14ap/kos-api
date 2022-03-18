<?php

namespace App\Services\Kost\Interfaces;

use App\Models\Kost;
use App\Dto\Kost\{
    PaginateDto,
    StoreDto,
    UpdateDto,
    DeleteDto,
    FindDto
};
use Illuminate\Pagination\LengthAwarePaginator;

interface KostServiceInterface
{
    /**
     * Paginate kost list
     * @param   PaginateDto $attribute
     * @return  LengthAwarePaginator
     */
    public function paginate(PaginateDto $attribute) : LengthAwarePaginator;

    /**
     * Create kost data
     * @param   StoreDto $attribute
     * @return  Kost
     */
    public function store(StoreDto $attribute) : Kost;

    /**
     * Update kost data
     * @param   UpdateDto $attribute
     * @return  bool
     */
    public function update(UpdateDto $attribute) : bool;

    /**
     * Delete kost data
     * @param   DeleteDto $attribute
     * @return  bool
     */
    public function delete(DeleteDto $attribute) : bool;
    
    /**
     * Find kost data for owner
     * @param   FindDto $attribute
     * @return  Kost
     */
    public function findForOwner(FindDto $attribute) : Kost;

}