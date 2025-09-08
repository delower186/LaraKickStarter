<div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
    <div class="flex justify-between mb-3">
        <h1 class="ml-5 mt-5 text-3xl font-bold mb-5">Categories</h1>
        @can($permission->format('create', 'category'))
            <flux:button variant="primary" class="mr-5 mt-5 text-3xl font-bold mb-5" wire:navigate href="categories/create" icon="plus-circle">Create Category</flux:button>
        @endcan
    </div>
    <flux:separator />
    <div class="flex mt-3 ml-3 mr-3 mb-3">
        @can($permission->format('view', 'category'))
            <flux:input wire:model="searchQuery" placeholder="Search" class="mr-3"/>
            <flux:button wire:click="search" variant="primary" icon="magnifying-glass" class="mr-3"></flux:button>
            <flux:button wire:click="refresh" variant="primary" icon="arrow-path" class="mr-3"></flux:button>
        @endcan
    </div>
    <flux:separator />
    <div class="mt-3 ml-3 mr-3 mb-3">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Title
                        </th>
                        <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                            Author
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @can($permission->format('view', 'category'))
                        @if ($categories->isNotEmpty())
                            @foreach ($categories as $category)
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                        {{ $category->id }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $category->title }}
                                    </td>
                                    <td class="px-6 py-4 bg-gray-50 dark:bg-gray-800">
                                        {{ $category->user->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($category->status == 0)
                                            <flux:badge color="red">Draft</flux:badge>
                                        @else
                                            <flux:badge color="green">Published</flux:badge>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @can($permission->format('edit', 'category'))
                                            <flux:button size="sm" variant="primary" icon="pencil-square" wire:navigate href="{{ route('categories.edit', $category->id) }}"></flux:button>
                                        @endcan
                                        @can($permission->format('delete', 'category'))
                                            <flux:button size="sm" variant="danger" icon="trash" wire:click="confirm({{ $category->id }})"></flux:button>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    @endcan
                </tbody>
            </table>
            <div class="mt-3 ml-3 mr-3 mb-3">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</div>
