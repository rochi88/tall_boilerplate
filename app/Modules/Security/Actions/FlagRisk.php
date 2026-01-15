<?php

declare(strict_types=1);

namespace App\Modules\Security\Actions;

use App\Modules\Security\Events\RiskFlagRaised;

final class FlagRisk
{
    public function handle(?int $userId, array $signals): void
    {
        event(new RiskFlagRaised($userId, $signals));
    }
}
