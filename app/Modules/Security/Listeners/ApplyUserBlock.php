<?php

declare(strict_types=1);

namespace App\Modules\Security\Listeners;

use App\Models\User;
use App\Modules\Security\Events\UserBlocked;
use Illuminate\Contracts\Queue\ShouldQueue;

final class ApplyUserBlock implements ShouldQueue
{
    public function handle(UserBlocked $event): void
    {
        User::whereKey($event->userId)->update([
            'is_blocked' => true,
        ]);
    }
}
