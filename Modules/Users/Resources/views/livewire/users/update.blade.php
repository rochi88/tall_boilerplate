<x-modal.card
    wire:model="show"
    max-width="md"
    align="center"
    z-index="z-40"
>
    <x-slot name="title">
        Editando informações da Igreja {{ $user->name ?? null }}
    </x-slot>
    <x-errors />
    <div class="flex flex-col gap-4 p-2">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12">
                <x-input
                    label="Igreja"
                    wire:model.defer="user.name"
                />
            </div>
        </div>
    </div>
    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">
            <x-button
                label="Cancelar"
                flat
                dark
                x-on:click="close"
            />
            <x-button
                label="Salvar"
                positive
                spinner="save"
                wire:click="save"
            />
        </div>
    </x-slot>
</x-modal.card>
