<?php

declare(strict_types=1);

namespace App\Modules\Security;

use App\Modules\Security\Events\RiskFlagRaised;
use App\Modules\Security\Events\UserBlocked;
use App\Modules\Security\Listeners\ApplyUserBlock;
use App\Modules\Security\Listeners\NotifySecurityTeam;
use App\Modules\Security\Listeners\PersistRiskFlag;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;

final class SecurityEventServiceProvider extends EventServiceProvider
{
    protected $listen = [
        RiskFlagRaised::class => [
            PersistRiskFlag::class,
            NotifySecurityTeam::class,
        ],
        UserBlocked::class => [
            ApplyUserBlock::class,
        ],
    ];
}
