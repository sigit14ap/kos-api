<?php

namespace App\Services\Kost;

use App\Services\Kost\Interfaces\KostServiceInterface;
use App\Models\Kost;
use App\Dto\Kost\{
    PaginateDto,
    StoreDto,
    UpdateDto,
    DeleteDto,
    FindDto
};
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class KostService implements KostServiceInterface
{
    /**
     * Paginate kost list
     * @param   PaginateDto $attribute
     * @return  LengthAwarePaginator
     */
    public function paginate(PaginateDto $attribute) : LengthAwarePaginator
    {
        return Kost::where('user_id', '=', $attribute->user_id)->paginate($attribute->per_page);
    }

    /**
     * Create kost data
     * @param   StoreDto $attribute
     * @return  Kost
     */
    public function store(StoreDto $attribute) : Kost
    {
        return Kost::create([
            'user_id'   =>  $attribute->user_id,
            'name'      =>  $attribute->name,
            'location'  =>  $attribute->location,
            'price'     =>  $attribute->price,
        ]);
    }

    /**
     * Update kost data
     * @param   UpdateDto $attribute
     * @return  bool
     */
    public function update(UpdateDto $attribute) : bool
    {
        $kost = Kost::where('user_id', '=', $attribute->user_id)->where('id', '=', $attribute->id)->first();

        if(!$kost){
            throw new ModelNotFoundException('Kost not found');
        }
        
        return $kost->update([
            'name'      =>  $attribute->name,
            'location'  =>  $attribute->location,
            'price'     =>  $attribute->price
        ]);
    }

    /**
     * Delete kost data
     * @param   DeleteDto $attribute
     * @return  bool
     */
    public function delete(DeleteDto $attribute) : bool
    {
        $kost = Kost::where('user_id', '=', $attribute->user_id)->where('id', '=', $attribute->id)->first();

        if(!$kost){
            throw new ModelNotFoundException('Kost not found');
        }
        
        return $kost->delete();
    }

    /**
     * Find kost data for owner
     * @param   FindDto $attribute
     * @return  Kost
     */
    public function findForOwner(FindDto $attribute) : Kost
    {
        $kost = Kost::where('user_id', '=', $attribute->user_id)->where('id', '=', $attribute->id)->first();

        if(!$kost){
            throw new ModelNotFoundException('Kost not found');
        }
        
        return $kost;
    }
}