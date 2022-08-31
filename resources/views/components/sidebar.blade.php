<aside
    :class="{ '-translate-x-72': !sidebar }"
    class="fixed bottom-0 left-0 top-16 z-10 flex w-48 flex-col border-r border-zinc-200 bg-white p-2 shadow transition-transform dark:border-zinc-700 dark:bg-zinc-800"
>
    <ul class="flex flex-col gap-2">
        @foreach ($menu as $item)
            <x-navlink
                icon="{{ $item->icon }}"
                route="{{ $item->route }}"
                label="{{ $item->label }}"
            />
        @endforeach
    </ul>
</aside>
