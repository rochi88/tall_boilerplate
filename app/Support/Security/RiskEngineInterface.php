<?php

declare(strict_types=1);

namespace App\Support\Security;

interface RiskEngineInterface
{
    public function evaluate(array $signals): RiskResult;
}
