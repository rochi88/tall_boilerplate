<?php

declare(strict_types=1);

namespace App\Modules\Security\Services;

use App\Support\Security\RiskResult;

final class RiskScoringService
{
    public function score(array $signals): RiskResult
    {
        $score = 0;
        $flags = [];

        if ($signals['new_device'] ?? false) {
            $score += 25;
            $flags[] = 'new_device';
        }

        if ($signals['geo_mismatch'] ?? false) {
            $score += 30;
            $flags[] = 'geo_mismatch';
        }

        if (($signals['failed_attempts'] ?? 0) > 3) {
            $score += 20;
            $flags[] = 'brute_force';
        }

        return new RiskResult(
            min($score, 100),
            $flags,
            $score >= 80,
            $score >= 50,
        );
    }
}
