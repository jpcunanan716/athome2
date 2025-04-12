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


        <!-- Image Preview -->
        <div class="flex flex-wrap gap-4 mt-4">
            @foreach($imagesPreview as $preview)
                <img src="{{ $preview }}" alt="Preview" class="w-24 h-24 object-cover rounded-lg shadow-sm">
            @endforeach
        </div>

        <!-- Upload Button -->
        <button type="submit" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
            Upload Images
        </button>
    </form>
</div>