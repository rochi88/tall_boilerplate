<?php

declare(strict_types=1);

namespace App\Modules\Security\Events;

final class RiskEvaluated
{
    public function __construct(
        public readonly ?int $userId,
        public readonly string $ip,
        public readonly int $score,
        public readonly array $flags,
        public readonly array $signals,
    ) {}
}
