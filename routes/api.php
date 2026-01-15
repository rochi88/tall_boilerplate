<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\ApiAuthController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth',
], function (): void {
    Route::post('login', [ApiAuthController::class, 'login']);
    Route::post('logout', [ApiAuthController::class, 'logout']);
    Route::post('register', [ApiAuthController::class, 'register']);
    Route::post('refresh', [ApiAuthController::class, 'refresh']);
    Route::get('me', [ApiAuthController::class, 'me']);
});
