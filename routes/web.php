<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Crud;
use App\Http\Livewire\Admin\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'activeUser'])->name('dashboard');

//authenticated
Route::middleware(['web', 'auth', 'activeUser'])->prefix('admin')->group(function () {
    Route::get('/', Dashboard::class)->name('admin');
    // Route::get('users', Users::class)->name('admin.users.index');
    // Route::get('users/{user}/edit', EditUser::class)->name('admin.users.edit');
    // Route::get('users/{user}', ShowUser::class)->name('admin.users.show');

});

// Route::view('/powergrid', 'powergrid-demo');
// Route::get('students', Crud::class);

require __DIR__.'/auth.php';
