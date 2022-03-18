<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use App\Helpers\Response;
use Illuminate\Http\Request;

class IsOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::user()->user_type == 'owner'){
            return $next($request);
        }else{
            return Response::withCode(403, 'Access Denied');
        }
    }
}
