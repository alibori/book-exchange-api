<?php

declare(strict_types=1);


/*
|--------------------------------------------------------------------------
| API V1 Routes
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Api\V1\Auth\LoginUserApiController;
use App\Http\Controllers\Api\V1\Auth\RegisterUserApiController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('register', RegisterUserApiController::class);
    Route::post('login', LoginUserApiController::class);
});
