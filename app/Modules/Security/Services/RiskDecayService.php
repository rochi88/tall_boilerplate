<?php

declare(strict_types=1);

namespace App\Modules\Security\Services;

use App\Modules\Security\Models\SecurityRiskFlag;

final class RiskDecayService
{
    public function decay(int $days = 7): void
    {
        SecurityRiskFlag::query()
            ->whereNull('resolved_at')
            ->where('created_at', '<=', now()->subDays($days))
            ->update([
                'severity' => 'low',
            ]);
    }
}
