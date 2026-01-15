<?php

use function Livewire\Volt\{state};

state(['flagId']);

$resolve = fn() =>
$this->dispatch('resolve-risk-flag', ['id' => $flagId]);
?>

<button wire:click="resolve">Resolve</button>