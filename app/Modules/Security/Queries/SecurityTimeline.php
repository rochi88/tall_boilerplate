<?php

declare(strict_types=1);

namespace App\Modules\Security\Queries;

use App\Modules\Security\Models\SecurityActivityLog;
use App\Modules\Security\Models\SecurityRiskFlag;

final class SecurityTimeline
{
    public function handle(int $userId): array
    {
        return [
            'activities' => SecurityActivityLog::where('user_id', $userId)->get(),
            'flags' => SecurityRiskFlag::where('user_id', $userId)->get(),
        ];
    }
}
