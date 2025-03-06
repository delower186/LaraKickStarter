<div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
    <div class="flex justify-between mb-3">
        <h1 class="ml-5 mt-5 text-3xl font-bold mb-5">Edit Blog</h1>
        <flux:button variant="primary" class="mr-5 mt-5 text-3xl font-bold mb-5" wire:navigate href="{{ route('blogs.index') }}" icon="arrow-uturn-left">Back</flux:button>
    </div>
    <flux:separator />
    <div class="mt-3 ml-3 mr-3 mb-3">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <form class="mt-3 ml-3 mr-3 mb-3 space-y-3" wire:submit="update">
                <flux:field>
                    <flux:label>Title</flux:label>
                    <flux:input placeholder="Enter Title" wire:model="title" type="text" />
                    <flux:error name="title" />
                </flux:field>
                <flux:field>
                    <flux:label>Category</flux:label>
                    <flux:select wire:model="category">
                        <flux:select.option>Choose category...</flux:select.option>
                        @if ($categories->count() > 0)
                            @foreach ($categories as $category)

                                <flux:select.option value="{{ $category->id }}">{{ $category->title }}</flux:select.option>

                            @endforeach

                        @endif
                    </flux:select>
                    <flux:error name="category" />
                </flux:field>
                <flux:field>
                    <flux:label>Author</flux:label>
                    <flux:input wire:model="author" Disabled />
                    <flux:error name="author" />
                </flux:field>
                <flux:field>
                    <flux:label>Content</flux:label>
                    <flux:textarea placeholder="Enter Content" rows="8" wire:model="content" type="text" />
                    <flux:error name="content" />
                </flux:field>
                <flux:field>
                    <flux:label>Image</flux:label>
                    <flux:input wire:model="image" type="file" />
                    <flux:error name="image" />
                </flux:field>
                <flux:radio.group wire:model="status" label="Status">
                    <flux:radio value="1" label="Publish"/>
                    <flux:radio value="0" label="Draft" />
                </flux:radio.group>
                <flux:button variant="primary" class="mr-5 mt-5 text-3xl font-bold mb-5" type="submit">Update</flux:button>
            </form>
            <div class="mt-3 ml-3 mr-3 mb-3">
                @if ($image)

                    @if ($image->getClientOriginalExtension() == 'png' || $image->getClientOriginalExtension() == 'jpg')
                        <img class="h-auto max-w-lg transition-all duration-300 rounded-lg cursor-pointer filter grayscale hover:grayscale-0" src="{{ $image->temporaryUrl() }}" alt="image description">
                    @else
                        <div class="h-auto max-w-lg transition-all duration-300 rounded-lg flex text-red-500">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                            </svg>
                            <p>Supported File Types Are JPG & PNG!</p>
                        </div>
                    @endif
                @else
                    <img class="h-auto max-w-lg transition-all duration-300 rounded-lg cursor-pointer filter grayscale hover:grayscale-0" src="{{ $fullPathOfOldImage }}" alt="image description">
                @endif
            </div>
        </div>
    </div>
</div>
