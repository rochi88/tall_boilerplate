<?php

declare(strict_types=1);

namespace App\Modules\Security\Listeners;

use App\Modules\Security\Events\RiskFlagRaised;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;

final class NotifySecurityTeam implements ShouldQueue
{
    public function handle(RiskFlagRaised $event): void
    {
        Log::warning('Security risk detected', [
            'user_id'   => $event->userId,
            'flag_type' => $event->flagType,
            'severity'  => $event->severity,
            'reason'    => $event->reason,
            'evidence'  => $event->evidence,
        ]);
    }
}
