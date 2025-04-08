<div class="p-4">
    <!-- Back Button -->
    <a href="{{ url('/home') }}" class="inline-block mb-4 text-blue-500 hover:underline">← Back to Listings</a>
    <h1 class="text-3xl font-bold">{{ $house->houseName }}</h1>

    <div class="grid grid-cols-5 grid-rows-5 gap-4">
            <div class="col-span-5 row-span-3">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden p-4">
    <!-- Alpine.js Image Gallery -->
    <div x-data="{ current: 0, images: {{ json_encode($house->media->pluck('image_path')) }} }">
        
        <!-- Main Display Image -->
        <div class="relative w-full h-full">
            <img :src="'{{ asset('storage') }}/' + images[current]"
                class="w-full h-full object-cover rounded-md shadow-md transition-opacity duration-500"
                x-transition:enter="opacity-0"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100">
            
            <!-- Navigation Buttons -->
            <button @click="current = (current === 0) ? images.length - 1 : current - 1"
                    class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-gray-700 text-white p-3 rounded-full">
                &#10094;
            </button>
            
            <button @click="current = (current === images.length - 1) ? 0 : current + 1"
                    class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-gray-700 text-white p-3 rounded-full">
                &#10095;
            </button>
        </div>

        <!-- Thumbnail Previews -->
        <div class="flex mt-4 space-x-2 overflow-x-auto">
            <template x-for="(image, index) in images" :key="index">
                <img :src="'{{ asset('storage') }}/' + image"
                    @click="current = index"
                    class="w-20 h-20 object-cover rounded-md cursor-pointer border-2 transition-all"
                    :class="{'border-blue-500 scale-110': current === index, 'border-gray-300': current !== index}">
            </template>
        </div>
    </div>
</div>
            </div>

                <div class="col-span-3 row-span-2 row-start-4">
                    <!-- House Details -->
                    <div class="p-6">
                        <h1 class="text-3xl font-bold">{{ $house->houseName }}</h1>
                        <p class="text-gray-600">{{ $house->houseNumberStreet }}, {{ $house->barangay }}, {{ $house->city }}, {{ $house->province }}</p>

                        <p class="text-gray-700 mt-2">Size: {{ $house->squareMeters }} m² | Floors: {{ $house->floors }}</p>
                        <p class="text-gray-700">Rooms: {{ $house->rooms }} | Bathrooms: {{ $house->bathrooms }}</p>
                        <p class="text-green-600 font-bold mt-2 text-xl">₱{{ number_format($house->price, 2) }}</p>

                        <!-- Furnished Badge -->
                        @if($house->furnished)
                            <span class="inline-block bg-green-500 text-white px-2 py-1 text-xs rounded mt-2">Furnished</span>
                        @endif

                        <p class="text-gray-600 mt-4 text-lg">{{ $house->description }}</p>

                        <!-- Contact Button -->
                        <button class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Contact Seller
                        </button>
                    </div>
                </div>

        <div className="col-span-2 row-span-2 col-start-4 row-start-4">
            <div class="mt-8">
                @livewire('house-rentals', ['house' => $house])
            </div>
        </div>
    </div>
</div>
