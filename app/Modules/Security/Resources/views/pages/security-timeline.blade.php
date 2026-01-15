<?php

use function Livewire\Volt\{computed};
use App\Modules\Security\Queries\SecurityTimeline;

$timeline = computed(
    fn() =>
    app(SecurityTimeline::class)->handle($userId)
);
?>

<h1>Security Timeline</h1>

@foreach ($timeline['activities'] as $event)
<div>{{ $event->event_type }} – {{ $event->created_at }}</div>
@endforeach

@foreach ($timeline['flags'] as $flag)
<div class="text-red-600">{{ $flag->reason }}</div>
@endforeach