<?php

declare(strict_types=1);

use App\Models\User;
use App\Modules\Security\Models\SecurityApproval;
use Symfony\Component\HttpKernel\Exception\HttpException;

it('prevents same user from approving their own request', function (): void {
    $user = User::factory()->create();

    $approval = SecurityApproval::create([
        'action_type' => 'unblock_user',
        'target_id' => 1,
        'requested_by' => $user->id,
    ]);

    expect(
        fn () => $approval->approve($user->id),
    )->toThrow(HttpException::class);
});
