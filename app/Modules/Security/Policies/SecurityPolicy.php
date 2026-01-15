<?php

declare(strict_types=1);

namespace App\Modules\Security\Policies;

use App\Models\User;

final class SecurityPolicy
{
    public function viewRisks(User $user): bool
    {
        if ($user->hasRole('security')) {
            return true;
        }

        return (bool) $user->hasRole('admin');
    }

    public function resolveRisk(User $user): bool
    {
        return $user->hasRole('security');
    }

    public function blockUser(User $user): bool
    {
        return $user->hasRole('security_admin');
    }
}
