<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        # For "1071 Specified key was too long; 
        # max key length is 767 bytes" issue
        Schema::defaultStringLength(191);

        # For "1071 Specified key was too long" issue for Mysql 8.0
        // Schema::defaultStringLength(125);
    }
}
