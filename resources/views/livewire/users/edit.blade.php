<div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
    <div class="flex justify-between mb-3">
        <h1 class="ml-5 mt-5 text-3xl font-bold mb-5">Edit User</h1>
        <flux:button variant="primary" class="mr-5 mt-5 text-3xl font-bold mb-5" wire:navigate href="{{ route('users.index') }}" icon="arrow-uturn-left">Back</flux:button>
    </div>
    <flux:separator />
    <div class="mt-3 ml-3 mr-3 mb-3">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <form class="mt-3 ml-3 mr-3 mb-3 space-y-3" wire:submit="update">
                <flux:field>
                    <flux:label>Role</flux:label>
                    <flux:select wire:model="role">
                        <flux:select.option>Choose role...</flux:select.option>
                        <flux:select.option value="0">Admin</flux:select.option>
                        <flux:select.option value="1">Vendor</flux:select.option>
                        <flux:select.option value="2">Customer</flux:select.option>
                    </flux:select>
                    <flux:error name="role" />
                </flux:field>
                <flux:radio.group wire:model="status" label="Status">
                    <flux:radio value="1" label="Active"/>
                    <flux:radio value="0" label="Inactive" />
                </flux:radio.group>
                <flux:button variant="primary" class="mr-5 mt-5 text-3xl font-bold mb-5" type="submit">Update</flux:button>
            </form>
        </div>
    </div>
</div>
