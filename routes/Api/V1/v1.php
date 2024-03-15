<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\Auth\LoginUserApiController;
use App\Http\Controllers\Api\V1\Auth\LogoutUserApiController;
use App\Http\Controllers\Api\V1\Auth\RegisterUserApiController;
use App\Http\Controllers\Api\V1\Book\BookApiController;
use App\Http\Controllers\Api\V1\User\UserApiController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API V1 Routes
|--------------------------------------------------------------------------
*/
Route::prefix('auth')->group(function () {
    Route::post('register', RegisterUserApiController::class);
    Route::post('login', LoginUserApiController::class);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('users', UserApiController::class)->only(['index', 'show', 'update', 'destroy']); // TODO: Implement destroy method

    Route::apiResource('books', BookApiController::class)->only(['index', 'show', 'store', 'update', 'destroy']); // TODO: Implement all methods

    Route::delete('logout', LogoutUserApiController::class);
});
