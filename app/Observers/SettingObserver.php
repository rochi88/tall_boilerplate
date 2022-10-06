<?php

namespace App\Observers;

use App\Models\Setting;
use Log;

class SettingObserver
{
    /**
     * Handle the Setting "created" event.
     *
     * @param \Modules\Setting\Entities\Setting $setting
     *
     * @return void
     */
    public function created(Setting $setting)
    {
        Log::info('Cache Cleared on settings create');

        return Setting::flushCache();
    }

    /**
     * Handle the Setting "updated" event.
     *
     * @param \Modules\Setting\Entities\Setting $setting
     *
     * @return void
     */
    public function updated(Setting $setting)
    {
        Log::info('Cache Cleared on settings update');

        return Setting::flushCache();
    }

    /**
     * Handle the Setting "deleted" event.
     *
     * @param \Modules\Setting\Entities\Setting $setting
     *
     * @return void
     */
    public function deleted(Setting $setting)
    {
        Log::info('Cache Cleared on settings delete');

        return Setting::flushCache();
    }

    /**
     * Handle the Setting "restored" event.
     *
     * @param \Modules\Setting\Entities\Setting $setting
     *
     * @return void
     */
    public function restored(Setting $setting)
    {
    }

    /**
     * Handle the Setting "force deleted" event.
     *
     * @param \Modules\Setting\Entities\Setting $setting
     *
     * @return void
     */
    public function forceDeleted(Setting $setting)
    {
    }
}
