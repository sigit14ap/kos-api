<?php

namespace App\Services\Kost\Interfaces;

use App\Models\Kost;
use App\Dto\Kost\{
    PaginateDto,
    StoreDto,
    UpdateDto,
    DeleteDto,
    FindDto,
    SearchDto,
    AskAvailabilityDto
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

    /**
     * Search kost data
     * @param   SearchDto $attribute
     * @return  LengthAwarePaginator
     */
    public function search(SearchDto $attribute) : LengthAwarePaginator;

    /**
     * Find kost data for user
     * @param   int $id
     * @return  Kost
     */
    public function findForUser(int $id) : Kost;

    /**
     * Ask availability
     * @param   AskAvailabilityDto $attribute
     * @return  bool
     */
    public function askAvailability(AskAvailabilityDto $attribute) : bool;

    /**
     * Summary data
     * @param   int $user_id
     * @return  array
     */
    public function summary(int $user_id) : array;

}