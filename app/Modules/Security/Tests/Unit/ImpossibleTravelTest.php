<?php

declare(strict_types=1);

use App\Models\User;
use App\Modules\Security\Models\SecurityActivityLog;
use App\Modules\Security\Services\ImpossibleTravelService;

it('detects impossible travel within short time window', function (): void {
    $user = User::factory()->create();

    SecurityActivityLog::create([
        'user_id' => $user->id,
        'country_code' => 'US',
        'created_at' => now()->subMinutes(10),
    ]);

    SecurityActivityLog::create([
        'user_id' => $user->id,
        'country_code' => 'BD',
        'created_at' => now(),
    ]);

    $service = app(ImpossibleTravelService::class);

    expect($service->detect($user->id))->toBeTrue();
});
