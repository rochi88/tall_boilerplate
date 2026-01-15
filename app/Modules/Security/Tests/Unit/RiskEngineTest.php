<?php

declare(strict_types=1);

use App\Support\Security\RiskEngineInterface;

it('blocks user when risk is high', function (): void {
    $engine = app(RiskEngineInterface::class);

    $result = $engine->evaluate([
        'is_new_device' => true,
        'geo_mismatch' => true,
        'failed_attempts' => 5,
    ]);

    expect($result->block)->toBeTrue();
});
