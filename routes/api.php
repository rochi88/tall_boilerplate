<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\ApiAuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// All Authentication Routes
Route::group([
    'middleware' => 'api',
    'prefix'     => 'auth',
], function () {
    Route::post('login', [ApiAuthController::class, 'login']);
    Route::post('logout', [ApiAuthController::class, 'logout']);
    Route::post('register', [ApiAuthController::class, 'register']);
    Route::post('refresh', [ApiAuthController::class, 'refresh']);
    Route::get('me', [ApiAuthController::class, 'me']);
});