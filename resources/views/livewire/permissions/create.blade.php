<div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
    <div class="flex justify-between mb-3">
        <h1 class="ml-5 mt-5 text-3xl font-bold mb-5">Create Permission</h1>
        <flux:button variant="primary" class="mr-5 mt-5 text-3xl font-bold mb-5" wire:navigate href="{{ route('permissions.index') }}" icon="arrow-uturn-left">Back</flux:button>
    </div>
    <flux:separator />
    <div class="mt-3 ml-3 mr-3 mb-3">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <form class="mt-3 ml-3 mr-3 mb-3 space-y-3" wire:submit="save">
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
                <flux:button variant="primary" class="mr-5 mt-5 text-3xl font-bold mb-5" type="submit" icon="document-plus">Save</flux:button>
            </form>
        </div>
    </div>
</div>
