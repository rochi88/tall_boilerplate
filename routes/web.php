<?php

use App\Http\Livewire\Backend\Dashboard;
use App\Http\Livewire\Addresslist;
use Illuminate\Support\Facades\Route;

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

Route::view('/', 'welcome')->name('welcome');

Route::middleware(['auth', 'activeUser'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    Route::get('logout', function () {
        auth()->logout();
        return redirect()->route('login');
    })->name('logout');
});
