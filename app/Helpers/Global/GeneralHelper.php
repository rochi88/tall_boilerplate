<?php

declare(strict_types = 1);

use Carbon\Carbon;

if (!function_exists('carbon')) {
    /**
     * Create a new Carbon instance from a time.
     *
     *
     * @return Carbon
     *
     * @throws Exception
     */
    function carbon($time)
    {
        return new Carbon($time);
    }
}
