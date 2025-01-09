<?php

declare(strict_types = 1);

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait Ownerable
{
    /**
     * Check if the authenticated user is the owner of the resource.
     */
    public function isOwner(Model $resource, string $key = 'user_id'): bool
    {
        return Auth::check() && $resource->{$key} === Auth::id();
    }
}
