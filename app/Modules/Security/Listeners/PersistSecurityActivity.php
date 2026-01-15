<?php

declare(strict_types=1);

namespace App\Modules\Security\Listeners;

use App\Modules\Security\Events\RiskEvaluated;
use App\Modules\Security\Models\SecurityActivityLog;
use Illuminate\Contracts\Queue\ShouldQueue;

final class PersistSecurityActivity implements ShouldQueue
{
    public string $queue = 'security';

    public function handle(RiskEvaluated $event): void
    {
        SecurityActivityLog::create([
            'user_id' => $event->userId,
            'ip_address' => $event->ip,
            'event_type' => 'risk_evaluated',
            'risk_score' => $event->score,
            'is_anomalous' => $event->score >= 50,
            'metadata' => $event->signals,
        ]);
    }
}
