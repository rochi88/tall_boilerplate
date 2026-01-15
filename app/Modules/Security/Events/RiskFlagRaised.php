<?php

declare(strict_types=1);

namespace App\Modules\Security\Events;

final readonly class RiskFlagRaised
{
    public function __construct(
        public ?int $userId,
        public string $flagType,
        public string $severity,
        public string $reason,
        public array $evidence,
    ) {}
}
