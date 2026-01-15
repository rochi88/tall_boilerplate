<?php

declare(strict_types=1);

use App\Models\User;
use App\Modules\Security\Models\SecurityActivityLog;
use App\Modules\Security\Models\SecurityRiskFlag;
use App\Modules\Security\Queries\SecurityTimeline;

it('reconstructs a complete security timeline', function (): void {
    $user = User::factory()->create();

    SecurityActivityLog::create([
        'user_id' => $user->id,
        'event_type' => 'login_attempt',
    ]);

    SecurityRiskFlag::create([
        'user_id' => $user->id,
        'flag_type' => 'phishing',
        'severity' => 'high',
        'reason' => 'Test',
    ]);

    $timeline = app(SecurityTimeline::class)->handle($user->id);

    expect($timeline['activities'])->toHaveCount(1)
        ->and($timeline['flags'])->toHaveCount(1);
});
