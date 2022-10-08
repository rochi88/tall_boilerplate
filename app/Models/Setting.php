<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $guarded = [];

    /**
     * flush Cache.
     *
     * @return void
     */
    public static function flushCache()
    {
        Cache::forget('settings.all');
    }
}
