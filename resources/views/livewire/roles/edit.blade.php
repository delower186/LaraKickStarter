<div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
    <div class="flex justify-between mb-3">
        <h1 class="ml-5 mt-5 text-3xl font-bold mb-5">Edit Role</h1>
        <flux:button variant="primary" class="mr-5 mt-5 text-3xl font-bold mb-5" wire:navigate href="{{ route('roles.index') }}" icon="arrow-uturn-left">Back</flux:button>
    </div>
    <flux:separator />
    <div class="mt-3 ml-3 mr-3 mb-3">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <form class="mt-3 ml-3 mr-3 mb-3 space-y-3" wire:submit="update">
                <flux:field>
                    <flux:label>Name</flux:label>
                    <flux:input placeholder="Enter Name" wire:model="name" type="text" />
                    <flux:error name="name" />
                </flux:field>
                {{-- <flux:field>
                    <flux:label>Author</flux:label>
                    <flux:input wire:model="author" Disabled />
                    <flux:error name="author" />
                </flux:field>
                <flux:radio.group wire:model="status" label="Status">
                    <flux:radio value="1" label="Publish"/>
                    <flux:radio value="0" label="Draft" />
                </flux:radio.group> --}}
                <flux:field>
                    <flux:legend>Permissions</flux:legend>
                    <flux:description>Choose Permission(s)</flux:description>
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <tbody>
                                @for ($i = 0; $i < $permissions->count(); $i += 4)
                                    <tr class="bg-white dark:bg-gray-800">
                                        @for ($j = $i; $j < $i + 4 && $j < $permissions->count(); $j++)
                                            <td class="px-1 py-1">
                                                <flux:checkbox value="{{ $permissions[$j]->name }}" wire:model.defer="selected_permissions" label="{{ $permissions[$j]->name }}" />
                                            </td>
                                        @endfor
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                </flux:field>
                <flux:button variant="primary" class="mr-5 mt-5 text-3xl font-bold mb-5" type="submit">Update</flux:button>
            </form>
        </div>
    </div>
</div>
