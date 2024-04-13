<?php

declare(strict_types = 1);

namespace App\Observers;

use App\Models\User;
use Log;

class UserObserver
{
    /**
     * Handle the user "created" event.
     *
     *
     * @return void
     */
    public function created(User $user)
    {
        Log::info('Cache Cleared on user create');

        return User::flushCache();
    }

    /**
     * Handle the user "updated" event.
     *
     *
     * @return void
     */
    public function updated(User $user)
    {
        Log::debug('Opcache Cleared on user update');

        return User::flushCache();
    }

    /**
     * Handle the user "deleted" event.
     *
     *
     * @return void
     */
    public function deleted(User $user)
    {
        Log::debug('Opcache Cleared on user delete');

        return User::flushCache();
    }

    /**
     * Handle the user "restored" event.
     *
     *
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     *
     *
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
