<?php

declare(strict_types=1);

namespace App\Modules\Security\Actions;

use App\Modules\Security\Events\UserBlocked;

final class BlockUser
{
    public function handle(int $userId, string $reason): void
    {
        event(new UserBlocked($userId, $reason));
    }
}
