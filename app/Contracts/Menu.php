<?php

declare(strict_types = 1);

namespace App\Contracts;

use Illuminate\Support\Collection;

interface Menu
{
    public function menus(): Collection;
}
