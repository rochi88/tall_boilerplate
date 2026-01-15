<?php

declare(strict_types=1);

namespace App\Modules\Security\Events;

final class RiskFlagRaised
{
    public function __construct(
        public readonly ?int $userId,
        public readonly string $flagType,
        public readonly string $severity,
        public readonly string $reason,
        public readonly array $evidence,
    ) {}
}
