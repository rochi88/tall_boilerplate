<?php

declare(strict_types=1);

use App\Providers\AppServiceProvider;
use App\Providers\ModulesServiceProvider;
use App\Providers\TelescopeServiceProvider;
use App\Providers\VoltServiceProvider;

return [
    AppServiceProvider::class,
    ModulesServiceProvider::class,
    TelescopeServiceProvider::class,
    VoltServiceProvider::class,
];
