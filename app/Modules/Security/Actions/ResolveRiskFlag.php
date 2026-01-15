<?php

declare(strict_types=1);

namespace App\Modules\Security\Actions;

use App\Modules\Security\Models\SecurityRiskFlag;

final class ResolveRiskFlag
{
    public function handle(int $flagId): void
    {
        SecurityRiskFlag::findOrFail($flagId)->resolve();
    }
}
