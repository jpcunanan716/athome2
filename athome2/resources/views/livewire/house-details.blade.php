<div class="p-12">
    <div class="grid grid-cols-5 grid-rows-5 gap-4">
        <!-- Section 1: Gallery (Full width) -->
        <div class="col-span-5">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden p-4">
                <!-- Gallery content from previous code -->
                <div x-data="{ isModalOpen: false, current: 0, images: {{ json_encode($house->media->pluck('image_path')) }} }">
                    <!-- Main Gallery Layout -->
                    <div class="flex gap-4 h-96">
                        <!-- Main Large Image -->
                        <div class="flex-1 cursor-pointer" @click="isModalOpen = true">
                            <img 
                                :src="'{{ asset('storage') }}/' + images[0]" 
                                class="w-full h-full object-cover rounded-lg transition-opacity hover:opacity-90"
                                loading="lazy"
                            >
                        </div>

                        <!-- 2x2 Grid for Next 4 Images -->
                        <div class="flex-1 grid grid-cols-2 grid-rows-2 gap-2">
                            <template x-for="(image, index) in images.slice(1, 5)" :key="index">
                                <div class="relative">
                                    <img 
                                        :src="'{{ asset('storage') }}/' + image" 
                                        @click="current = index + 1; isModalOpen = true"
                                        class="w-full h-full object-cover rounded-lg cursor-pointer hover:opacity-90 transition-opacity"
                                        loading="lazy"
                                    >
                                    <!-- Overlay for More Images -->
                                    <div 
                                        x-show="index === 3 && images.length > 5"
                                        @click="isModalOpen = true"
                                        class="absolute inset-0 bg-black/50 flex items-center justify-center text-white font-bold rounded-lg cursor-pointer hover:bg-black/40 transition-colors"
                                    >
                                        +<span x-text="images.length - 5"></span> more
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Modal Lightbox -->
                    <div 
                        x-show="isModalOpen" 
                        class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4"
                        @click.self="isModalOpen = false"
                    >
                        <div class="bg-white rounded-lg max-w-4xl w-full p-6">
                            <div class="flex justify-end mb-4">
                                <button 
                                    @click="isModalOpen = false"
                                    class="text-gray-500 hover:text-gray-700 text-2xl"
                                >
                                    ✕
                                </button>
                            </div>
                            
                            <div class="relative">
                                <img 
                                    :src="'{{ asset('storage') }}/' + images[current]" 
                                    class="w-full h-96 object-contain rounded-lg"
                                    loading="lazy"
                                >
                                
                                <button 
                                    @click.stop="current = (current === 0) ? images.length - 1 : current - 1"
                                    class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/80 text-gray-800 p-3 rounded-full shadow hover:bg-white transition-colors"
                                >
                                    ←
                                </button>
                                <button 
                                    @click.stop="current = (current === images.length - 1) ? 0 : current + 1"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/80 text-gray-800 p-3 rounded-full shadow hover:bg-white transition-colors"
                                >
                                    →
                                </button>
                            </div>

                            <div class="flex gap-2 mt-4 overflow-x-auto pb-2">
                                <template x-for="(image, index) in images" :key="index">
                                    <img 
                                        :src="'{{ asset('storage') }}/' + image"
                                        @click.stop="current = index"
                                        class="w-16 h-16 object-cover rounded cursor-pointer border-2 transition-all"
                                        :class="{ 'border-blue-500 scale-105': current === index, 'border-transparent': current !== index }"
                                        loading="lazy"
                                    >
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 2: House Details -->
        <div class="col-span-3 row-start-2 p-6">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden p-4">

                <!-- House details content -->
                    <h1 class="text-3xl font-bold">{{ $house->houseName }}</h1>
                        <p class="text-black-600 font-semibold">{{ $house->city }}, {{ $house->province }}</p>
                        <p class="text-gray-700">Rooms: {{ $house->total_rooms }} | Bathrooms: {{ $house->total_bathrooms }} Max Occupants: {{ $house->total_occupants}}</p>
                        <p class="text-green-600 font-bold mt-2 text-xl">₱{{ number_format($house->price, 2) }}</p>

                        <!-- Host Information -->
                            <div class="flex items-center mt-1">
                                @if($house->user->profile_photo_path)
                                    <img 
                                        src="{{ asset('storage/'.$house->user->profile_photo_path) }}" 
                                        alt="{{ $house->user->name }}"
                                        class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-sm"
                                    >
                                @else
                                    <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center border-2 border-white shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                @endif
                                    <p class="p-2 ext-sm font-medium text-gray-900">
                                        Hosted by {{ $house->user->name }}
                                    </p>
                            </div>

                            <!-- Contact Button -->
                            
                            <button onclick="$dispatch('open-new-conversation-modal', { houseId: {{ $house->id }} })"">
                                <a 
                                    href="{{ route('conversations.create', ['house_id' => $house->id]) }}"
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                    </svg>
                                    Contact about this property
                                </a>

                            </button>
                            
                        
            </div>
        </div>

        <!-- Section 3: Additional Content -->
        <div class="col-span-3 col-start-1 row-start-3 p-4">
            <!-- Truncated description with Read More button -->
            <div x-data="{ showModal: false }">
                <p class="text-gray-600 mt-4 text-lg">
                    {{ Str::limit($house->description, 400) }}
                    @if(strlen($house->description) > 400)
                        <button 
                            @click="showModal = true"
                            class="text-black hover:text-black-700 text-sm font-medium ml-1 focus:outline-none"
                        >
                            Read More
                        </button>
                    @endif
                </p>

                <!-- Modal -->
                <template x-teleport="body">
                    <div 
                        x-show="showModal"
                        x-transition.opacity
                        class="fixed inset-0 z-50 flex items-center justify-center p-4"
                        @keydown.escape.window="showModal = false"
                    >
                        <!-- Overlay -->
                        <div 
                            class="absolute inset-0 bg-black/50"
                            @click="showModal = false"
                        ></div>
                        
                        <!-- Modal content -->
                        <div 
                            class="relative w-full max-w-2xl max-h-[80vh] overflow-y-auto bg-white rounded-lg shadow-xl"
                            @click.outside="showModal = false"
                        >
                            <div class="p-6">
                                <!-- Header -->
                                <div class="flex items-center justify-between mb-4">
                                    <h1 class="text-xl font-semibold">About this property</h1>
                                    <button 
                                        @click="showModal = false"
                                        class="text-gray-500 hover:text-gray-700"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                
                                <!-- Content -->
                                <div class="prose max-w-none">
                                    {!! nl2br(e($house->description)) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
        <!-- Section 4: Additional Content -->
        <div class="col-span-3 col-start-1 row-start-4">
            @livewire('house-rentals', ['house' => $house])
        </div>

        <!-- Section 5: Additional Content -->
        <div class="col-span-3 col-start-1 row-start-5">
            
        </div>

        <!-- Section 6: Rental Component (Right Sidebar) -->
        <div class="col-span-2 row-span-4 col-start-4 row-start-2">
            <div class="bg-white rounded-lg p-4">
                @livewire('house-rentals', ['house' => $house])
            </div>
        </div>
    </div>
</div>