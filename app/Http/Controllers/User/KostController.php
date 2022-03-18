<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Services\Kost\Interfaces\KostServiceInterface;
use App\Http\Requests\Kost\SearchRequest;
use App\Dto\Kost\{
    AskAvailabilityDto,
    SearchDto
};
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
     * Search kost
     * @method  GET
     * @link    '/api/v1/user/kost/search'
     * @param   KostServiceInterface $service
     * @param   SearchRequest $request
     * @return  Illuminate\Http\JsonResponse
    */
    public function search(KostServiceInterface $service, SearchRequest $request) : JsonResponse
    {
        $data = $service->search(new SearchDto([
            'per_page'      =>  $request->input('per_page', 15),
            'search'        =>  $request->search,
            'min_price'     =>  $request->min_price,
            'max_price'     =>  $request->max_price,
            'sort_price'    =>  in_array($request->sort_price, ['ASC', 'DESC']) ? $request->sort_price : 'ASC',
        ]));
        
        return Response::successWithDataResponse('List kost', $data);
    }

    /**
     * Detail kost data
     * @method  GET
     * @link    '/api/v1/user/kost/detail/{id}'
     * @param   KostServiceInterface $service
     * @param   int $id
     * @return  Illuminate\Http\JsonResponse
    */
    public function detail(KostServiceInterface $service, int $id) : JsonResponse
    {
        try{
            $data = $service->findForUser($id);
            
            return Response::successWithDataResponse('Detail kost', $data);
        }catch(ModelNotFoundException $e){
            return Response::withCode(404, $e->getMessage());
        }
    }

    /**
     * Detail kost data
     * @method  POST
     * @link    '/api/v1/user/kost/ask-availability/{id}'
     * @param   KostServiceInterface $service
     * @param   int $id
     * @return  Illuminate\Http\JsonResponse
    */
    public function ask_availability(KostServiceInterface $service, int $id) : JsonResponse
    {
        
        if($this->user->credit < 5){
            return Response::withCode(400, 'Credit is not enough');
        }

        try{
            $service->askAvailability(new AskAvailabilityDto([
                'id'        =>  $id,
                'user_id'   =>  $this->user->id
            ]));
            
            return Response::successResponse('Room availability has been asked');
        }
        catch(ModelNotFoundException $e){
            return Response::withCode(404, $e->getMessage());
        }
        catch(\Throwable $th){
            \Log::error("[KostController][ask_availability] : " . $th->getMessage());
            return Response::withCode(500, $th->getMessage());
        }
    }
}
