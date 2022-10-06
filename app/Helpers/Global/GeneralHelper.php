<?php

use Carbon\Carbon;

if (!function_exists('carbon')) {
    /**
     * Create a new Carbon instance from a time.
     *
     * @param $time
     *
     * @throws Exception
     *
     * @return Carbon
     */
    function carbon($time)
    {
        return new Carbon($time);
    }
}
