<?php

declare(strict_types=1);

namespace App\Modules\Security\Actions;

use App\Modules\Security\Models\SecurityApproval;

final class RequestSecurityApproval
{
    public function handle(
        string $actionType,
        int $targetId,
        int $requestedBy,
        ?string $reason = null,
    ): void {
        SecurityApproval::create([
            'action_type' => $actionType,
            'target_id' => $targetId,
            'requested_by' => $requestedBy,
            'reason' => $reason,
        ]);
    }
}
