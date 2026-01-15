<?php

declare(strict_types=1);

namespace App\Support\Security;

final readonly class RiskResult
{
    public function __construct(
        public int $score,
        public array $flags,
        public bool $block,
        public bool $requireMfa,
    ) {}
}
