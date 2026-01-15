<?php

use function Livewire\Volt\{computed};
use App\Modules\Security\Queries\ListRiskFlags;

$flags = computed(fn() => app(ListRiskFlags::class)->handle());
?>

<div>
    <h1 class="text-xl font-bold">Security Risk Flags</h1>

    @foreach ($flags as $flag)
    <div class="border p-2 mb-2">
        {{ $flag->severity }} – {{ $flag->reason }}
    </div>
    @endforeach
</div>