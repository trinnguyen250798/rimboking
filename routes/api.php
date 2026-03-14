<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\Admin;
use App\Http\Controllers\Api\Client;
use Illuminate\Support\Facades\Route;
use App\Enums\UserRole;
use App\Http\Controllers\Api\Auth\LoginRequest;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\DistrictController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned the the "api" middleware group.
|
*/

// V1 versioning
Route::prefix('v1')->group(function () {

    // ─── Auth ────────────────────────────────────────────────────────────────
    Route::prefix('auth')->group(function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('logout', [AuthController::class, 'logout']);
            Route::get('me', [AuthController::class, 'me']);
            Route::post('refresh', [AuthController::class, 'refresh']);
        });
    });
 // ─── Location ────────────────────────────────────────────────────────────────
    Route::prefix('location')->group(function () {
        Route::get('countries',[CountryController::class,'index']);
        Route::get('provinces',[ProvinceController::class,'index']);
        Route::get('provinces/{country_code}',[ProvinceController::class,'getByCountry']);
        Route::get('districts/{province_code}',[DistrictController::class,'getByProvince']);
    });


    Route::prefix('admin')->group(function () { 
        // ─── Authenticated routes ────────────────────────────────────────────────
        Route::post('login', [AuthController::class, 'loginAdmin']);
        Route::middleware(['auth:sanctum', 'admin.role'])->group(function () {
            Route::get('me', [AuthController::class, 'me']);
            // Users management
            Route::apiResource('users', Admin\UserController::class)->parameters(['users' => 'ulid']);

           Route::apiResource('hotels', Admin\HotelController::class)->parameters(['hotels' => 'hotel']);

            Route::post('hotels/{hotel}/upload-thumbnail', [Admin\HotelController::class, 'upload_thumbnail']);
        });
        


    
        Route::middleware('auth:sanctum')->group(function () {
            // Client specific routes
            Route::get('profile', [Client\UserController::class, 'show']);
            Route::put('profile', [Client\UserController::class, 'update']);
        });
    });

});
