<?php

declare(strict_types=1);

namespace App\Modules\Security\Services;

use App\Modules\Security\Models\SecurityActivityLog;

final class ImpossibleTravelService
{
    public function detect(int $userId): bool
    {
        $logs = SecurityActivityLog::where('user_id', $userId)
            ->latest()
            ->take(2)
            ->get();

        if ($logs->count() < 2) {
            return false;
        }

        [$current, $previous] = [$logs[0], $logs[1]];

        return $current->country_code !== $previous->country_code
            && $current->created_at->diffInMinutes($previous->created_at) < 30;
    }
}
