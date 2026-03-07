<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;
use App\Enums\UserRole;
use App\Http\Controllers\Api\Auth\LoginRequest;

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
        Route::post('login',    [AuthController::class, 'login']);

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('logout',  [AuthController::class, 'logout']);
            Route::get('me',       [AuthController::class, 'me']);
            Route::post('refresh', [AuthController::class, 'refresh']);
        });
    });


    Route::prefix('admin')->group(function () {
        Route::post('login', [AuthController::class, 'loginAdmin']);
        Route::middleware(['auth:sanctum','admin.role'])
            ->group(function () {
                Route::get('me', [AuthController::class, 'me']);
                // Users management
                Route::apiResource('users', Admin\UserController::class)
                    ->parameters(['users' => 'ulid']);
        });
    });


    // ─── Authenticated routes ────────────────────────────────────────────────
    Route::middleware('auth:sanctum')->group(function () {
        // Client specific routes
        Route::get('profile', [Client\UserController::class, 'show']);
        Route::put('profile', [Client\UserController::class, 'update']);
    });

});
