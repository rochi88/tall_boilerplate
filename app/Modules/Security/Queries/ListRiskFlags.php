<?php

declare(strict_types=1);

namespace App\Modules\Security\Queries;

use App\Modules\Security\Models\SecurityRiskFlag;

final class ListRiskFlags
{
    public function handle()
    {
        return SecurityRiskFlag::latest()->get();
    }
}
