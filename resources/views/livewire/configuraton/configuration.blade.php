<div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
    <div class="flex justify-between mb-3">
        <h1 class="ml-5 mt-5 text-3xl font-bold mb-5">Configuration</h1>
    </div>
    <flux:separator />
    <div class="mt-3 ml-3 mr-3 mb-3">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <form class="mt-3 ml-3 mr-3 mb-3 space-y-3" wire:submit="update">
                <flux:field>
                    <flux:label>Site Name</flux:label>
                    <flux:input placeholder="Enter Site Name" wire:model="site_name" type="text" />
                    <flux:error name="site_name" />
                </flux:field>
                <flux:field>
                    <flux:label>Logo</flux:label>
                    <flux:input wire:model="logo" type="file" />
                    <flux:error name="logo" />
                </flux:field>
                <flux:separator />
                <div class="mb-6">
                    <div class="grid grid-cols-2 gap-6 items-start">
                        <!-- Column 1: Existing Logo -->
                        <div>
                            <p class="text-sm  mb-2">Existing Logo</p>
                            <img 
                                src="{{ $logoPreview }}" 
                                alt="Existing Logo" 
                                class="h-auto max-w-lg rounded-lg filter grayscale hover:grayscale-0 transition-all duration-300 cursor-pointer"
                            >
                        </div>

                        <!-- Column 2: New Logo Preview -->
                        <div>
                            <p class="text-sm  mb-2">Selected Logo</p>
                            @if ($logo)

                                @if ($logo->getClientOriginalExtension() == 'png' || $logo->getClientOriginalExtension() == 'jpg')
                                    <img 
                                        src="{{ $logo->temporaryUrl() }}" 
                                        alt="New Logo Preview" 
                                        class="h-auto max-w-lg rounded-lg filter grayscale hover:grayscale-0 transition-all duration-300 cursor-pointer"
                                    >
                                @else
                                    <div class="h-auto max-w-lg transition-all duration-300 rounded-lg flex text-red-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                        </svg>
                                        <p>Supported File Types Are JPG & PNG!</p>
                                    </div>
                                @endif

                            @endif
                        </div>
                    </div>
                </div>
                <flux:separator />
                <flux:field>
                    <flux:label>Favicon Icon</flux:label>
                    <flux:input wire:model="favicon" type="file" />
                    <flux:error name="favicon" />
                </flux:field>
                <flux:separator />
                <div class="mb-6">
                    <div class="grid grid-cols-2 gap-6 items-start">
                        <!-- Column 1: Existing Logo -->
                        <div>
                            <p class="text-sm  mb-2">Existing Favicon</p>
                            <img 
                                src="{{ $faviconPreview }}" 
                                alt="Existing Logo" 
                                class="h-auto max-w-lg rounded-lg filter grayscale hover:grayscale-0 transition-all duration-300 cursor-pointer"
                            >
                        </div>

                        <!-- Column 2: New Logo Preview -->
                        <div>
                            <p class="text-sm  mb-2">Selected Favicon</p>
                            @if ($favicon)

                                @if ($favicon->getClientOriginalExtension() == 'ico')
                                    <img 
                                        src="{{ $favicon->temporaryUrl() }}" 
                                        alt="New Logo Preview" 
                                        class="h-auto max-w-lg rounded-lg filter grayscale hover:grayscale-0 transition-all duration-300 cursor-pointer"
                                    >
                                @else
                                    <div class="h-auto max-w-lg transition-all duration-300 rounded-lg flex text-red-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                        </svg>
                                        <p>Supported File Type is ICO!</p>
                                    </div>
                                @endif

                            @endif
                        </div>
                    </div>
                </div>
                <flux:separator />
                <flux:button variant="primary" class="mr-5 mt-5 text-3xl font-bold mb-5" type="submit" icon="document-plus">Update</flux:button>
            </form>
        </div>
    </div>
</div>
