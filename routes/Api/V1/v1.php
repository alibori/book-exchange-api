<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\Auth\LoginUserApiController;
use App\Http\Controllers\Api\V1\Auth\LogoutUserApiController;
use App\Http\Controllers\Api\V1\Auth\RegisterUserApiController;
use App\Http\Controllers\Api\V1\Book\BookApiController;
use App\Http\Controllers\Api\V1\Book\BookApplicationApiController;
use App\Http\Controllers\Api\V1\Book\CategoryApiController;
use App\Http\Controllers\Api\V1\Loan\LoanApiController;
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

    Route::apiResource('books', BookApiController::class)->only(['index', 'store', 'update', 'destroy']);

    Route::prefix('books')->group(function () {
        Route::apiResource('applications', BookApplicationApiController::class)->only(['index', 'store', 'update', 'destroy']); // TODO: Implement index/update/destroy methods
    });

    Route::get('categories', CategoryApiController::class);

    Route::apiResource('loans', LoanApiController::class)->except(['destroy']);

    Route::delete('logout', LogoutUserApiController::class);
});
