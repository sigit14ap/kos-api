<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Owner\KostController;
use App\Http\Controllers\Owner\DashboardController;
use App\Http\Controllers\User\KostController as UserKostController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {

    /**
     * Authentication route
     * @link api/v1/auth
    */
    Route::prefix('auth')->group(function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
    });

    Route::middleware(['auth:api'])->group(function () {

        /**
         * Owner route
         * @link api/v1/owner
        */
        Route::middleware(['IsOwner'])->prefix('owner')->group(function () {

            /**
             * Dashboard route for owner
             * @link api/v1/owner/dashboard
            */
            Route::prefix('dashboard')->group(function () {
                Route::get('/summary', [DashboardController::class, 'summary']);
            });

            /**
             * Kost route for owner
             * @link api/v1/owner/kost
            */
            Route::prefix('kost')->group(function () {
                Route::get('/', [KostController::class, 'paginate']);
                Route::post('/', [KostController::class, 'store']);
                Route::get('/{id}', [KostController::class, 'detail']);
                Route::put('/{id}', [KostController::class, 'update']);
                Route::delete('/{id}', [KostController::class, 'delete']);
            });

        });

        /**
         * User route
         * @link api/v1/user
        */
        Route::prefix('user')->group(function () {

            /**
             * Kost route for user
             * @link api/v1/user/kost
            */
            Route::prefix('kost')->group(function () {
                Route::get('/search', [UserKostController::class, 'search']);
                Route::get('/detail/{id}', [UserKostController::class, 'detail']);
                Route::post('/ask-availability/{id}', [UserKostController::class, 'ask_availability'])->middleware('IsUser');
            });

        });
    });
    
});