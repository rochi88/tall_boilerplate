@push('pagetitle', 'Igrejas')

<div class="h-full">
    <x-table :options="$tableOptions" />

    <livewire:churches.create />
    <livewire:churches.update />
</div>