<?php

declare(strict_types=1);

namespace App\Modules\Security\Services;

use App\Support\Security\RiskEngineInterface;
use App\Support\Security\RiskResult;

final class RuleBasedRiskEngine implements RiskEngineInterface
{
    public function evaluate(array $signals): RiskResult
    {
        $score = 0;
        $flags = [];

        if ($signals['is_new_device'] ?? false) {
            $score += 25;
            $flags[] = 'new_device';
        }

        if ($signals['ip_reputation'] === 'suspicious') {
            $score += 40;
            $flags[] = 'suspicious_ip';
        }

        if ($signals['geo_mismatch'] ?? false) {
            $score += 30;
            $flags[] = 'geo_mismatch';
        }

        if ($signals['failed_attempts'] > 3) {
            $score += 20;
            $flags[] = 'brute_force_pattern';
        }

        return new RiskResult(
            score: min($score, 100),
            flags: $flags,
            block: $score >= 80,
            requireMfa: $score >= 50 && $score < 80,
        );
    }
}
