<?php

namespace App\Providers;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
        if (config('app.env') === 'production') {
            \URL::forceScheme('https');
        }

        // For "1071 Specified key was too long;
        // max key length is 767 bytes" issue
        Schema::defaultStringLength(191);

        // For "1071 Specified key was too long" issue for Mysql 8.0
        // Schema::defaultStringLength(125);

        // Model observer for flush cache
        User::observe(\App\Observers\UserObserver::class);
        Setting::observe(\App\Observers\SettingObserver::class);
    }
}
