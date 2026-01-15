<?php

declare(strict_types=1);

namespace App\Enums;

enum ApiStatus: string
{
    case SUCCESS = 'success';
    case ERROR = 'error';
}
