<?php

declare(strict_types=1);

use App\Models\User;
use App\Modules\Security\Http\Middleware\PhishingDetectionMiddleware;
use App\Modules\Security\Models\SecurityRiskFlag;
use Illuminate\Support\Facades\Route;

it('flags suspicious activity via middleware', function (): void {
    Route::middleware([
        PhishingDetectionMiddleware::class,
    ])->get('/test-secure', fn (): string => 'ok');

    $user = User::factory()->create();
    $this->actingAs($user);

    $this->get('/test-secure');

    expect(SecurityRiskFlag::count())->toBeGreaterThan(0);
});
