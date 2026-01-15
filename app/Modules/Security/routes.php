<?php

declare(strict_types=1);

use App\Modules\Security\Http\Controllers\SecurityController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Module Routes
|--------------------------------------------------------------------------
|
| Here is where you can register module routes.
|
*/

Route::get('/Security', [SecurityController::class, 'index']);

Route::middleware(['web', 'auth'])
    ->prefix('security')
    ->name('security.')
    ->group(function (): void {
        Route::view('/risks', 'Security::pages.risks.index')
            ->name('risks.index');

        Route::view('/risk-flags/{id}', 'Security::pages.risk-flags.review')
            ->name('risk-flags.review');
    });
