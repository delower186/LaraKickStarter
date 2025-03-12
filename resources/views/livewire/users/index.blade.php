<div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
    <div class="flex justify-between mb-3">
        <h1 class="ml-5 mt-5 text-3xl font-bold mb-5">Users</h1>
    </div>
    <flux:separator />
    <div class="flex mt-3 ml-3 mr-3 mb-3">
        @can($permission->format('view', 'role'))
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
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Role
                        </th>
                        <th scope="col" class="px-6 py-3 bg-gray-50 dark:bg-gray-800">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @can($permission->format('view', 'role'))
                        @if ($users->isNotEmpty())
                            @foreach ($users as $user)
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50 dark:text-white dark:bg-gray-800">
                                        {{ $user->id }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $user->name }}
                                    </td>
                                    <td class="px-6 py-4 bg-gray-50 dark:bg-gray-800">
                                        {{ $user->email }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($user->roles->isNotEmpty())
                                            @foreach ($user->roles as $role)
                                            <flux:badge size="sm" color="indigo">{{ $role->name }}</flux:badge>
                                            @endforeach
                                        @else
                                            <flux:badge size="sm" color="red">NONE</flux:badge>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 bg-gray-50 dark:bg-gray-800">
                                        @if ($user->status == 0)
                                            <flux:badge color="red">Inactive</flux:badge>
                                        @else
                                            <flux:badge color="green">Active</flux:badge>
                                        @endif
                                    </td>
                                    {{-- @if (!$user->role == 0) --}}
                                        <td class="px-6 py-4">
                                            @can($permission->format('update', 'role'))
                                                <flux:button size="sm" variant="primary" icon="pencil-square" wire:navigate href="{{ route('users.edit', $user->id) }}"></flux:button>
                                            @endcan
                                            @can($permission->format('delete', 'role'))
                                                <flux:button size="sm" variant="danger" icon="trash" wire:click="confirm({{ $user->id }})"></flux:button>
                                            @endcan
                                        </td>
                                    {{-- @endif --}}
                                </tr>
                            @endforeach
                        @endif
                    @endcan
                </tbody>
            </table>
            <div class="mt-3 ml-3 mr-3 mb-3">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
