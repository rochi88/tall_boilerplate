<?php

declare(strict_types = 1);

use App\Http\Controllers\Api\V1\{AuthController, IPController};
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
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [AuthController::class, 'me']);
});

// All Service Api Routes
Route::group([
    'middleware' => ['ip-whitelist', 'api', 'jwt-verify'],
    'prefix'     => 'service',
], function () {
    Route::apiResource('ips', IPController::class);
});
