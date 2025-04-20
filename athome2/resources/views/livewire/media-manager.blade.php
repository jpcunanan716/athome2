<div>
    <h1 class="text-2xl font-bold mb-4">Media Manager</h1>

    <!-- Dropzone for uploading multiple images -->
    <form wire:submit.prevent="save">
        <div 
            class="border-2 border-dashed border-gray-300 p-6 text-center cursor-pointer"
            ondragover="event.preventDefault()" 
            ondrop="handleDrop(event)"
            onclick="document.getElementById('images').click()"
        >
            <p class="text-gray-600">Drag & Drop images here or click to select</p>
            <input type="file" id="images" wire:model="images" multiple class="hidden">
        </div>
        @error('images')
            <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror
        @error('images.*')
            <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror

        <!-- Loading Animation - Shown during upload processing -->
        <div wire:loading wire:target="save" class="mt-4">
            <div class="flex items-center justify-center">
                <svg class="animate-spin h-8 w-8 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="ml-2 text-blue-500">Processing images...</span>
            </div>
        </div>

        <!-- Image Preview with Delete Buttons -->
        <div class="flex flex-wrap gap-4 mt-4">
            @foreach($imagesPreview as $index => $preview)
                <div class="relative group">
                    <img src="{{ $preview }}" alt="Preview" class="w-24 h-24 object-cover rounded-lg shadow-sm">
                    <button 
                        type="button"
                        wire:click="removeImage({{ $index }})" 
                        class="absolute top-0 right-0 bg-red-500 text-white rounded-full p-1 transform translate-x-1/3 -translate-y-1/3 opacity-0 group-hover:opacity-100 transition-opacity"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endforeach
        </div>

        <!-- Upload Button with Loading State -->
        <button 
            type="submit" 
            class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 disabled:bg-blue-300 disabled:cursor-not-allowed"
            wire:loading.attr="disabled"
            wire:loading.class="bg-blue-300"
        >
            <span wire:loading.remove wire:target="save">Upload Images</span>
            <span wire:loading wire:target="save">Uploading...</span>
        </button>
    </form>

    <!-- Existing Media Display -->
    @if($mediaList && $mediaList->count() > 0)
        <h2 class="text-xl font-semibold mt-8 mb-4">Existing Media</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($mediaList as $media)
                <div class="relative group">
                    <img src="{{ asset('storage/' . $media->image_path) }}" alt="House Media" class="w-full h-48 object-cover rounded-lg shadow">
                    <button 
                        type="button"
                        wire:click="delete({{ $media->id }})" 
                        wire:loading.attr="disabled"
                        class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>
            @endforeach
        </div>
    @endif
</div>

<script>
    function handleDrop(event) {
        event.preventDefault();
        const files = event.dataTransfer.files;
        const fileInput = document.getElementById('images');
        
        // Create a DataTransfer object and add the dropped files
        const dataTransfer = new DataTransfer();
        Array.from(files).forEach(file => {
            if (file.type.startsWith('image/')) {
                dataTransfer.items.add(file);
            }
        });
        
        // Set the files to the input and dispatch a change event
        fileInput.files = dataTransfer.files;
        fileInput.dispatchEvent(new Event('change', { bubbles: true }));
    }
</script>