<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Services\Auth\Interfaces\AuthServiceInterface;
use App\Helpers\Response;
use App\Dto\Auth\RegisterDto;
use App\Http\Requests\Auth\{
    RegisterRequest,
    LoginRequest
};
use Auth;

class AuthController extends Controller
{
    /**
     * Register user
     * @method  POST
     * @link    '/api/v1/auth/register'
     * @param   AuthServiceInterface $service
     * @param   RegisterRequest $request
     * @return  Illuminate\Http\JsonResponse
    */
    public function register(AuthServiceInterface $service, RegisterRequest $request) : JsonResponse
    {
        $user = $service->register(new RegisterDto([
            'name'      =>  $request->name,
            'email'     =>  $request->email,
            'password'  =>  Hash::make($request->password),
            'user_type' =>  $request->user_type
        ]));

        event(new Registered($user));

        return Response::successWithDataResponse('Register success. You can login now', $user);
    }

    /**
     * Login user
     * @method  POST
     * @link    '/api/v1/auth/login'
     * @param   AuthServiceInterface $service
     * @param   LoginRequest $request
     * @return  Illuminate\Http\JsonResponse
    */
    public function login(AuthServiceInterface $service, LoginRequest $request) : JsonResponse
    {
        $token = Auth::attempt($request->only('email', 'password'));
        
        if(!$token){
            return Response::withCode(401, 'Email and password does not match');
        }

        return Response::successWithDataResponse('Login success', [
            'access_token'  =>  $token,
            'user'          =>  Auth::user()
        ]);
    }
}
