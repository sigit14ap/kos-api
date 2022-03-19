<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\Kost\Interfaces\KostServiceInterface;
use App\Helpers\Response;
use Auth;

class DashboardController extends Controller
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
     * Summary dashboard for owner
     * @method  GET
     * @link    '/api/v1/owner/dashboard/summary'
     * @param   KostServiceInterface $service
     * @return  Illuminate\Http\JsonResponse
    */
    public function summary(KostServiceInterface $service) : JsonResponse
    {
        $data = $service->summary($this->user->id);
        
        return Response::successWithDataResponse('Summary data', $data);
    }
}
