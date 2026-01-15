<?php

declare(strict_types=1);

use App\Modules\Security\Models\SecurityRiskFlag;
use App\Modules\Security\Services\RiskDecayService;

it('reduces severity of old unresolved risk flags', function (): void {
    $flag = SecurityRiskFlag::create([
        'flag_type' => 'phishing',
        'severity' => 'high',
        'reason' => 'Test',
        'created_at' => now()->subDays(10),
    ]);

    app(RiskDecayService::class)->decay(7);

    expect($flag->fresh()->severity)->toBe('low');
});
