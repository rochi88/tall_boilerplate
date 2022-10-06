<div class="rounded-md bg-white p-8 shadow dark:bg-zinc-800">
    <div class="flex flex-col items-center justify-between gap-2 sm:flex-row">
        <div class="flex flex-1 flex-col gap-2 sm:flex-row">
            <x-input
                icon="search"
                wire:model.lazy="search"
                placeholder="Pesquisar registros"
            />
            <x-dropdown>
                <x-slot name="trigger">
                    <x-button
                        icon="adjustments"
                        label="Opções"
                        info
                        full
                        outline
                    />
                </x-slot>
                <x-dropdown.item
                    icon="plus"
                    label="Adicionar registro"
                    spinner="showCreateForm"
                    wire:click="showCreateForm"
                />
                @if ($options['selectedRows'])
                    <x-dropdown.item
                        separator
                        icon="trash"
                        label="Excluir selecionados"
                        x-on:confirm="{
                            id: 'delete',
                            title: 'Deseja mesmo excluir {{ count($options['selectedRows']) }} registros?',
                            icon: 'error',
                            accept: {
                                label: 'Excluir',
                            },
                            reject: {
                                label: 'Cancelar',
                            },
                            method: 'delete',
                        }"
                    />
                    <x-dropdown.item
                        icon="cursor-click"
                        label="Selecionar todos"
                        spinner="selectAll"
                        wire:click='selectAll'
                    />
                @endif
            </x-dropdown>
        </div>
    </div>
    <div class="flex items-center py-4 text-center text-sm font-light">
        @if ($options['selectedRows'])
            @if ($options['selectAll'])
                <span class="w-full py-2 sm:w-auto">{{ count($options['selectedRows']) }} registros selecionados</span>
            @else
                <div class="flex items-center">
                    <span class="w-full sm:w-auto">
                        {{ count($options['selectedRows']) . (count($options['selectedRows']) === 1 ? ' registro selecionado.' : ' registros selecionados.') }}
                    </span>
                </div>
            @endif
        @else
            <span class="w-full py-2 sm:w-auto">Nenhum registro selecionado</span>
        @endif
    </div>
    <div
        class="soft-scrollbar relative overflow-x-auto rounded-md border-x border-t border-zinc-200 dark:border-zinc-700">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-zinc-200 bg-white text-xs uppercase dark:border-zinc-700 dark:bg-zinc-800">
                <tr>
                    <th
                        scope="col"
                        class="border-r border-zinc-200 px-6 py-4 dark:border-zinc-700"
                    >
                        <div class="flex items-center">
                            <x-checkbox wire:model="selectAllRows" />
                        </div>
                    </th>
                    @foreach ($options['titles'] as $title)
                        <th
                            scope="col"
                            class="border-r border-zinc-200 px-6 py-4 dark:border-zinc-700"
                        >
                            {{ $title }}
                        </th>
                    @endforeach
                    <th
                        scope="col"
                        class="px-4 py-4 text-center align-middle"
                    >
                        Ações
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($options['collection'] as $item)
                    <tr
                        wire:key="table-item-{{ $item->id }}"
                        @class([
                            'bg-zinc-50 dark:bg-zinc-600' => !$this->isChecked($item->id),
                            'bg-indigo-200 dark:bg-indigo-500' => $this->isChecked($item->id),
                            'font-medium',
                            'border-b',
                            'border-zinc-200 dark:border-zinc-700',
                        ])
                    >
                        <td
                            class="w-4 border-r border-zinc-200 bg-white px-6 py-4 dark:border-zinc-700 dark:bg-zinc-800">
                            <div class="flex items-center">
                                <x-checkbox
                                    value="{{ $item->id }}"
                                    wire:model="selectedRows"
                                />
                            </div>
                        </td>
                        @foreach ($options['values'] as $value)
                            <td
                                scope="row"
                                class="whitespace-nowrap border-r border-zinc-200 px-6 py-4 dark:border-zinc-700"
                            >
                                {{ eval("echo \$item->$value ?? '-';") }}
                            </td>
                        @endforeach
                        <td class="w-10 bg-white px-6 py-4 align-middle dark:bg-zinc-800">
                            <div class="flex w-full gap-2.5">
                                <x-button.circle
                                    icon="pencil-alt"
                                    info
                                    flat
                                    spinner="edit"
                                    wire:click="edit('{{ $item->id }}')"
                                />
                                <x-button.circle
                                    icon="trash"
                                    negative
                                    flat
                                    spinner='delete'
                                    x-on:confirm="{
                                      id: 'delete',
                                      title: 'Deseja mesmo excluir esse registro?',
                                      icon: 'error',
                                      accept: {
                                        label: 'Excluir',
                                      },
                                      reject: {
                                        label: 'Cancelar',
                                      },
                                      method: 'delete',
                                      params: '{{ $item->id }}'
                                    }"
                                    {{-- wire:click="$emit('modal-delete', '{{$modelName}}', '{{ $item->id }}')" --}}
                                />
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr class='border-b border-zinc-200 bg-zinc-50 font-medium dark:border-zinc-700 dark:bg-zinc-600'>
                        <td
                            colspan='100%'
                            class='px-6 py-4 text-center'
                        >
                            Nenhum item encontrado.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="pt-4">
        {{ $options['collection']->links() }}
    </div>
</div>
