<?php

declare(strict_types=1);

use App\Support\Security\RiskEngineInterface;

it('blocks user when combined risk is critical', function (): void {
    $engine = app(RiskEngineInterface::class);

    $result = $engine->evaluate([
        'is_new_device' => true,
        'geo_mismatch' => true,
        'failed_attempts' => 5,
        'ip_reputation' => 'suspicious',
    ]);

    expect($result->score)->toBeGreaterThanOrEqual(80)
        ->and($result->block)->toBeTrue()
        ->and($result->requireMfa)->toBeFalse();
});
