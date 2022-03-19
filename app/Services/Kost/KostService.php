<?php

namespace App\Services\Kost;

use App\Services\Kost\Interfaces\KostServiceInterface;
use App\Models\{
    User,
    Kost,
    RoomAvailability
};
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
use Illuminate\Database\Eloquent\ModelNotFoundException;
use DB;

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

    /**
     * Search kost data
     * @param   SearchDto $attribute
     * @return  LengthAwarePaginator
     */
    public function search(SearchDto $attribute) : LengthAwarePaginator
    {
        return Kost::when($attribute->search, function($query) use($attribute){
            $query->where(function($q) use($attribute){
                $q->where('name', 'LIKE', '%'.$attribute->search.'%')
                ->orWhere('location', 'LIKE', '%'.$attribute->search.'%');
            });
        })
        ->when($attribute->min_price, function($query) use($attribute){
            $query->where('price', '>=', $attribute->min_price);
        })
        ->when($attribute->max_price, function($query) use($attribute){
            $query->where('price', '<=', $attribute->max_price);
        })
        ->orderBy('price', $attribute->sort_price)
        ->paginate($attribute->per_page);
    }

    /**
     * Find kost data for user
     * @param   int $id
     * @return  Kost
     */
    public function findForUser(int $id) : Kost
    {
        $kost = Kost::where('id', '=', $id)->first();

        if(!$kost){
            throw new ModelNotFoundException('Kost not found');
        }
        
        return $kost;
    }

    /**
     * Ask availability
     * @param   AskAvailabilityDto $attribute
     * @return  bool
     */
    public function askAvailability(AskAvailabilityDto $attribute) : bool
    {
        DB::beginTransaction();

        try{
            $kost = Kost::where('id', '=', $attribute->id)->first();

            if(!$kost){
                throw new ModelNotFoundException('Kost not found');
            }

            RoomAvailability::create([
                'kost_id'   =>  $kost->id,
                'user_id'   =>  $attribute->user_id
            ]);

            $user = User::where('id', '=', $attribute->user_id)->first();

            $user->update([
                'credit' => $user->credit - 5
            ]);

            DB::commit();

            return true;

        }catch(\Throwable $th){
            DB::rollback();
            throw $th;
        }
    }

    /**
     * Summary data
     * @param   int $user_id
     * @return  array
     */
    public function summary(int $user_id) : array
    {
        return [
            'total_kost'                =>  Kost::where('user_id', '=', $user_id)->count(),
            'total_ask_availability'    =>  RoomAvailability::whereHas('kost', function($query) use($user_id) {
                $query->where('user_id', '=', $user_id);
            })->count(),
        ];
    }
}