<?php

declare(strict_types=1);

namespace App\Modules\Security\Listeners;

use App\Modules\Security\Events\RiskFlagRaised;
use App\Modules\Security\Models\SecurityRiskFlag;
use Illuminate\Contracts\Queue\ShouldQueue;

final class PersistRiskFlag implements ShouldQueue
{
    public string $queue = 'security';

    public function handle(RiskFlagRaised $event): void
    {
        SecurityRiskFlag::create([
            'user_id' => $event->userId,
            'flag_type' => $event->flagType,
            'severity' => $event->severity,
            'reason' => $event->reason,
            'evidence' => $event->evidence,
        ]);
    }
}
