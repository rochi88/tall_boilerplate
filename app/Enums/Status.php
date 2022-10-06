<?php

namespace App\Enums;

use App\Traits\Headline;
use App\Traits\Options;
use Spatie\Enum\Laravel\Enum;

/**
 * @method static self active()
 * @method static self inactive()
 */
final class Status extends Enum
{
    use Headline;
    use Options;

    protected static function values(): array
    {
        return [
            'active'   => 1,
            'inactive' => 0,
        ];
    }

    protected static function labels(): array
    {
        return [
            'active'   => __('Active'),
            'inactive' => __('Inactive'),
        ];
    }
}
