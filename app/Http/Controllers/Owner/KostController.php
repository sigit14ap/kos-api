<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Services\Kost\Interfaces\KostServiceInterface;
use App\Dto\Kost\{
    PaginateDto,
    StoreDto,
    UpdateDto,
    DeleteDto,
    FindDto
};
use App\Http\Requests\Kost\StoreRequest;
use App\Helpers\Response;
use Auth;

class KostController extends Controller
{
    private $user;

    public function __construct(Request $request)
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    /**
     * Paginate kost list
     * @method  GET
     * @link    '/api/v1/owner/kost'
     * @param   KostServiceInterface $service
     * @param   Request $request
     * @return  Illuminate\Http\JsonResponse
    */
    public function paginate(KostServiceInterface $service, Request $request) : JsonResponse
    {
        $data = $service->paginate(new PaginateDto([
            'user_id'   =>  $this->user->id,
            'per_page'  =>  $request->input('per_page', 15)
        ]));
        
        return Response::successWithDataResponse('List kost', $data);
    }

    /**
     * Detail kost data
     * @method  GET
     * @link    '/api/v1/owner/kost/{id}'
     * @param   KostServiceInterface $service
     * @param   int $id
     * @return  Illuminate\Http\JsonResponse
    */
    public function detail(KostServiceInterface $service, int $id) : JsonResponse
    {
        try{
            $data = $service->findForOwner(new FindDto([
                'id'        =>  $id,
                'user_id'   =>  $this->user->id
            ]));
            
            return Response::successWithDataResponse('Detail kost', $data);
        }catch(ModelNotFoundException $e){
            return Response::withCode(404, $e->getMessage());
        }
    }

    /**
     * Create kost data
     * @method  POST
     * @link    '/api/v1/owner/kost'
     * @param   KostServiceInterface $service
     * @param   StoreRequest $request
     * @return  Illuminate\Http\JsonResponse
    */
    public function store(KostServiceInterface $service, StoreRequest $request) : JsonResponse
    {
        $data = $service->store(new StoreDto([
            'user_id'   =>  $this->user->id,
            'name'      =>  $request->name,
            'location'  =>  $request->location,
            'price'     =>  $request->price,
        ]));
        
        return Response::successWithDataResponse('Success create kost', $data);
    }

    /**
     * Update kost data
     * @method  PUT
     * @link    '/api/v1/owner/kost/{id}'
     * @param   KostServiceInterface $service
     * @param   StoreRequest $request
     * @param   int $id
     * @return  Illuminate\Http\JsonResponse
    */
    public function update(KostServiceInterface $service, StoreRequest $request, int $id) : JsonResponse
    {
        try{
            $data = $service->update(new UpdateDto([
                'id'        =>  $id,
                'user_id'   =>  $this->user->id,
                'name'      =>  $request->name,
                'location'  =>  $request->location,
                'price'     =>  $request->price,
            ]));
            
            return Response::successResponse('Success update kost');
        }catch(ModelNotFoundException $e){
            return Response::withCode(404, $e->getMessage());
        }
    }

    /**
     * Delete kost data
     * @method  DELETE
     * @link    '/api/v1/owner/kost/{id}'
     * @param   KostServiceInterface $service
     * @param   int $id
     * @return  Illuminate\Http\JsonResponse
    */
    public function delete(KostServiceInterface $service, int $id) : JsonResponse
    {
        try{
            $data = $service->delete(new DeleteDto([
                'id'        =>  $id,
                'user_id'   =>  $this->user->id
            ]));
            
            return Response::successResponse('Success delete kost');
        }catch(ModelNotFoundException $e){
            return Response::withCode(404, $e->getMessage());
        }
    }
}