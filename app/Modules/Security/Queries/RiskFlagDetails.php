<?php

declare(strict_types=1);

namespace App\Modules\Security\Queries;

use App\Modules\Security\Models\SecurityRiskFlag;

final class RiskFlagDetails
{
    public function handle(int $id): SecurityRiskFlag
    {
        return SecurityRiskFlag::query()
            ->with('user')
            ->findOrFail($id);
    }
}
