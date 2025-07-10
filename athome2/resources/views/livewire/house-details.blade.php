<div class="px-4 sm:px-8 md:px-1 lg:px-24 xl:px-32 py-8 md:py-12 min-h-screen">
    <div class="max-w-7xl mx-auto">
        <!-- Section 1: Gallery (Full width) -->
        <div class="w-full mb-4 flex flex-col items-center">
            <div class="bg-white rounded-lg overflow-hidden p-2 sm:p-4 w-full max-w-md md:max-w-full mx-auto">
                <!-- Gallery content remains the same -->
                <div 
                    x-data="{
                        isModalOpen: false, 
                        current: 0, 
                        images: {{ json_encode($house->media->pluck('image_path')) }},
                        touchStartX: 0,
                        touchEndX: 0,
                        next() { this.current = (this.current + 1) % this.images.length },
                        prev() { this.current = (this.current === 0) ? this.images.length - 1 : this.current - 1 },
                        handleTouchStart(e) { this.touchStartX = e.touches[0].clientX },
                        handleTouchMove(e) { this.touchEndX = e.touches[0].clientX },
                        handleTouchEnd() {
                            if (this.touchEndX === 0) return;
                            if (this.touchStartX - this.touchEndX > 40) { this.next() }
                            if (this.touchEndX - this.touchStartX > 40) { this.prev() }
                            this.touchStartX = 0; this.touchEndX = 0;
                        }
                    }"
                    >
                    <!-- Mobile: Swipable Carousel, Centered, No Arrows -->
                    <div 
                        class="block md:hidden relative w-full h-56 flex flex-col items-center justify-center"
                        x-on:touchstart="handleTouchStart($event)"
                        x-on:touchmove="handleTouchMove($event)"
                        x-on:touchend="handleTouchEnd()"
                    >
                        <template x-for="(image, index) in images" :key="index">
                            <img 
                                x-show="current === index"
                                :src="'{{ asset('storage') }}/' + image"
                                class="absolute inset-0 w-full h-full object-cover rounded-lg transition-all duration-300"
                                loading="lazy"
                                @click="isModalOpen = true"
                                x-transition:enter="transition-opacity duration-300"
                                x-transition:enter-start="opacity-0"
                                x-transition:enter-end="opacity-100"
                                x-transition:leave="transition-opacity duration-300"
                                x-transition:leave-start="opacity-100"
                                x-transition:leave-end="opacity-0"
                            >
                        </template>
                        <!-- Dots -->
                        <div class="absolute bottom-2 left-1/2 -translate-x-1/2 flex gap-1 z-10">
                            <template x-for="(image, index) in images" :key="index">
                                <span 
                                    @click="current = index"
                                    class="w-2 h-2 rounded-full cursor-pointer border border-white"
                                    :class="current === index ? 'bg-fuchsia-700 scale-125' : 'bg-gray-300'"
                                ></span>
                            </template>
                        </div>
                    </div>
                    <!-- Tablet/Desktop: Grid Gallery -->
                    <div class="hidden md:flex gap-4 h-72 md:h-96">
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
                    <!-- Modal Lightbox (all screens) -->
                    <div 
                        x-show="isModalOpen" 
                        class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-2 sm:p-4"
                        @click.self="isModalOpen = false"
                    >
                        <div class="bg-white rounded-lg max-w-2xl sm:max-w-4xl w-full p-2 sm:p-6">
                            <div class="flex justify-end mb-2 sm:mb-4">
                                <button 
                                    @click="isModalOpen = false"
                                    class="text-gray-500 hover:text-gray-700 text-xl sm:text-2xl"
                                >
                                    ✕
                                </button>
                            </div>
                            <div class="relative">
                                <img 
                                    :src="'{{ asset('storage') }}/' + images[current]" 
                                    class="w-full h-[40vh] sm:h-[60vh] object-contain rounded-lg"
                                    loading="lazy"
                                >
                                <button 
                                    @click.stop="prev"
                                    class="absolute left-2 sm:left-4 top-1/2 -translate-y-1/2 flex items-center justify-center w-8 h-8 sm:w-12 sm:h-12 rounded-full bg-white/90 text-gray-800 shadow-lg hover:bg-fuchsia-100 hover:text-fuchsia-700 transition-all text-xl sm:text-3xl focus:outline-none focus:ring-2 focus:ring-fuchsia-500"
                                    aria-label="Previous image"
                                    x-show="images.length > 1"
                                >
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                </button>
                                <button 
                                    @click.stop="next"
                                    class="absolute right-2 sm:right-4 top-1/2 -translate-y-1/2 flex items-center justify-center w-8 h-8 sm:w-12 sm:h-12 rounded-full bg-white/90 text-gray-800 shadow-lg hover:bg-fuchsia-100 hover:text-fuchsia-700 transition-all text-xl sm:text-3xl focus:outline-none focus:ring-2 focus:ring-fuchsia-500"
                                    aria-label="Next image"
                                    x-show="images.length > 1"
                                >
                                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </button>
                            </div>
                            <div class="flex gap-1 sm:gap-2 mt-2 overflow-x-auto pb-2 justify-center">
                                <template x-for="(image, index) in images" :key="index">
                                    <img 
                                        :src="'{{ asset('storage') }}/' + image"
                                        @click.stop="current = index"
                                        class="w-8 h-8 sm:w-12 sm:h-12 object-cover rounded cursor-pointer border-2 transition-all"
                                        :class="{ 'border-fuchsia-700 scale-105': current === index, 'border-transparent': current !== index }"
                                        loading="lazy"
                                    >
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid: Mobile = single column, Desktop = 3+2 columns -->
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-4">
            <!-- Section 2: House Details (Mobile: full width, Desktop: 3/5 width) -->
            <div class="lg:col-span-3 flex flex-col gap-4 md:gap-6">
                <div class="bg-white rounded-xl shadow p-3 md:p-6 w-full text-center md:text-left">
                    <h1 class="text-xl md:text-2xl lg:text-3xl font-bold text-black text-center md:text-left">{{ $house->houseName }}</h1>
                    <div class="flex flex-wrap items-center gap-2 mt-2 justify-center md:justify-start">
                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-fuchsia-50 text-fuchsia-700 text-xs md:text-sm font-semibold">
                            {{ $house->city }}, {{ $house->province }}
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-fuchsia-50 text-fuchsia-700 text-xs md:text-sm font-semibold">
                            {{ $house->housetype }}
                        </span>
                    </div>
                    <div class="flex flex-wrap gap-4 mt-4 text-gray-700 text-xs md:text-base justify-center md:justify-start">
                        <span><strong>Rooms:</strong> {{ $house->total_rooms }}</span>
                        <span><strong>Bathrooms:</strong> {{ $house->total_bathrooms }}</span>
                        <span><strong>Max Occupants:</strong> {{ $house->total_occupants }}</span>
                    </div>
                    <div class="mt-4 flex items-center gap-2 justify-center md:justify-start">
                        <span class="text-green-600 font-bold text-lg md:text-2xl">₱{{ number_format($house->price, 2) }}</span>
                        <span class="text-gray-500 text-xs md:text-sm">per day</span>
                    </div>
                    
                    <!-- Host Information -->
                    <div class="flex flex-col md:flex-row items-left md:items-start mt-6 gap-3 md:gap-4">
                        @if($house->user->profile_photo_path)
                            <img 
                                src="{{ asset('storage/'.$house->user->profile_photo_path) }}" 
                                alt="{{ $house->user->name }}"
                                class="w-12 h-12 md:w-14 md:h-14 rounded-full object-cover border-2 border-fuchsia-200 shadow"
                            >
                        @else
                            <div class="w-12 h-12 md:w-14 md:h-14 rounded-full bg-gray-200 flex items-center justify-center border-2 border-fuchsia-200 shadow">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 md:h-7 md:w-7 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                        @endif
                        <div class="text-left md:text-left">
                            <p class="text-sm md:text-base font-semibold text-gray-900 text-left ">Hosted by {{ $house->user->name }}</p>
                            <a 
                                href="{{ route('conversations.create', ['house_id' => $house->id]) }}"
                                class="inline-flex items-left mt-1 px-3 py-1 md:px-4 md:py-2 border border-fuchsia-700 rounded-md shadow-sm text-xs md:text-sm font-medium text-fuchsia-700 bg-white hover:bg-fuchsia-50 focus:outline-none focus:ring-2 focus:ring-fuchsia-500 transition"
                            >
                                <svg class="-ml-1 mr-2 h-4 w-4 md:h-5 md:w-5 text-fuchsia-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                </svg>
                                Contact about this property
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Description with Read More -->
                <div class="bg-white rounded-xl shadow p-3 md:p-6 w-full text-center md:text-left">
                    <div x-data="{ showModal: false }">
                        <h2 class="text-base md:text-xl font-semibold text-black mb-2 text-left md:text-left">About this property</h2>
                        <div class="text-gray-700 text-xs md:text-base whitespace-pre-line text-left md:text-left">
                            {{ strlen($house->description) > 400 
                                ? Str::limit($house->description, 400) 
                                : $house->description }}
                            @if(strlen($house->description) > 400)
                                <button 
                                    @click="showModal = true"
                                    class="text-fuchsia-700 hover:underline text-xs md:text-sm font-medium ml-1 focus:outline-none"
                                >
                                    Read More
                                </button>
                            @endif
                        </div>
                        <!-- Modal -->
                        <template x-teleport="body">
                            <div 
                                x-show="showModal"
                                x-transition.opacity
                                class="fixed inset-0 z-50 flex items-center justify-center p-2 sm:p-4"
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
                                    <div class="p-4 sm:p-6">
                                        <div class="flex items-center justify-between mb-4">
                                            <h1 class="text-base md:text-xl font-semibold text-fuchsia-800">About this property</h1>
                                            <button 
                                                @click="showModal = false"
                                                class="text-gray-500 hover:text-gray-700"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div class="prose max-w-none text-gray-700 whitespace-pre-line">
                                            {!! nl2br(e($house->description)) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Section 4: Amenities -->
                <div class="bg-white rounded-xl shadow p-3 md:p-6 w-full text-center md:text-left">
                    <h2 class="text-base md:text-xl font-semibold text-gray-900 mb-4 md:mb-6 text-left md:text-left">Amenities</h2>
                    <div class="grid grid-cols-2 sm:grid-cols-2 gap-x-4 gap-y-3 md:gap-x-8 md:gap-y-4">
                        @if($house->has_kitchen)
                            <div class="flex items-left gap-2 md:gap-3 justify-left md:justify-start">
                                <!-- Kitchen Icon -->
                                <svg class="w-5 h-5 md:w-7 md:h-7 text-black" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <rect x="5" y="10" width="14" height="7" rx="2" stroke="currentColor"/>
                                    <rect x="8" y="7" width="8" height="3" rx="1.5" stroke="currentColor"/>
                                    <path d="M3 13h2M19 13h2" stroke="currentColor"/>
                                    <path d="M10 7V5M14 7V5" stroke="currentColor"/>
                                </svg>
                                <span class="text-xs md:text-base text-black">Kitchen</span>
                            </div>
                        @endif
                        @if($house->has_wifi)
                            <div class="flex items-left gap-2 md:gap-3 justify-left md:justify-start">
                                <!-- WiFi Icon -->
                                <svg class="w-5 h-5 md:w-7 md:h-7 text-black" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M2 8.82a15.91 15.91 0 0 1 20 0M6 13.06a10.94 10.94 0 0 1 12 0M9.91 17.5a4 4 0 0 1 4.18 0" stroke="currentColor"/>
                                    <circle cx="12" cy="20" r="1" fill="currentColor"/>
                                </svg>
                                <span class="text-xs md:text-base text-black">Wifi</span>
                            </div>
                        @endif
                        @if($house->has_parking)
                            <div class="flex items-left gap-2 md:gap-3 justify-left md:justify-start">
                                <!-- Parking Icon -->
                                <svg class="w-5 h-5 md:w-7 md:h-7 text-black" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <rect x="4" y="11" width="16" height="5" rx="2" stroke="currentColor"/>
                                    <path d="M7 11V9a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v2" stroke="currentColor"/>
                                    <circle cx="7" cy="18" r="2" stroke="currentColor" fill="none"/>
                                    <circle cx="17" cy="18" r="2" stroke="currentColor" fill="none"/>
                                </svg>
                                <span class="text-xs md:text-base text-black">Free parking</span>
                            </div>
                        @endif
                        @if($house->has_aircon)
                            <div class="flex items-left gap-2 md:gap-3 justify-left md:justify-start">
                                <!-- Aircon Icon -->
                                <svg class="w-5 h-5 md:w-7 md:h-7 text-black" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M4 12h9a3 3 0 1 0 0-6 3 3 0 0 0-3 3" stroke="currentColor"/>
                                    <path d="M4 18h13a2 2 0 1 0 0-4 2 2 0 0 0-2 2" stroke="currentColor"/>
                                    <path d="M4 6h5" stroke="currentColor"/>
                                </svg>
                                <span class="text-xs md:text-base text-black">Air Conditioning unit</span>
                            </div>
                        @endif
                        @if($house->has_gym)
                            <div class="flex items-left gap-2 md:gap-3 justify-left md:justify-start">
                                <!-- Gym Icon -->
                                <svg class="w-5 h-5 md:w-7 md:h-7 text-black" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <rect x="2" y="10" width="2" height="4" rx="1" stroke="currentColor"/>
                                    <rect x="4" y="8" width="2" height="8" rx="1" stroke="currentColor"/>
                                    <rect x="6" y="11" width="12" height="2" rx="1" stroke="currentColor"/>
                                    <rect x="18" y="8" width="2" height="8" rx="1" stroke="currentColor"/>
                                    <rect x="20" y="10" width="2" height="4" rx="1" stroke="currentColor"/>
                                </svg>
                                <span class="text-xs md:text-base text-black">Gym</span>
                            </div>
                        @endif
                        @if($house->has_patio)
                            <div class="flex items-left gap-2 md:gap-3 justify-left md:justify-start">
                                <!-- Patio Icon -->
                                <svg class="w-5 h-5 md:w-7 md:h-7 mr-2 md:mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M12 3C7 3 3 7 3 12h18c0-5-4-9-9-9z" stroke="currentColor"/>
                                    <line x1="12" y1="12" x2="12" y2="21" stroke="currentColor"/>
                                    <rect x="8" y="19" width="8" height="2" rx="1" stroke="currentColor"/>
                                </svg>
                                <span class="text-xs md:text-base text-black">Patio / Balcony</span>
                            </div>
                        @endif
                        @if($house->has_pool)
                            <div class="flex items-left gap-2 md:gap-3 justify-left md:justify-start">
                                <!-- Pool Icon -->
                                <svg class="w-5 h-5 md:w-7 md:h-7 mr-2 md:mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M3 17c1.5 1 3.5 1 5 0s3.5-1 5 0 3.5 1 5 0" stroke="currentColor"/>
                                    <path d="M3 13c1.5 1 3.5 1 5 0s3.5-1 5 0 3.5 1 5 0" stroke="currentColor"/>
                                    <path d="M7 7v6M17 7v6" stroke="currentColor"/>
                                    <path d="M7 7c0-1.5 2-1.5 2 0v6" stroke="currentColor"/>
                                    <path d="M17 7c0-1.5-2-1.5-2 0v6" stroke="currentColor"/>
                                </svg>
                                <span class="text-xs md:text-base text-black">Pool</span>
                            </div>
                        @endif
                        @if($house->is_petfriendly)
                            <div class="flex items-left gap-2 md:gap-3 justify-left md:justify-start">
                                <!-- Pet Friendly Icon -->
                                <svg class="w-5 h-5 md:w-7 md:h-7 mr-2 md:mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <ellipse cx="12" cy="17" rx="3" ry="2.5" stroke="currentColor"/>
                                    <circle cx="7.5" cy="13" r="1.5" stroke="currentColor"/>
                                    <circle cx="16.5" cy="13" r="1.5" stroke="currentColor"/>
                                    <circle cx="9" cy="10" r="1.2" stroke="currentColor"/>
                                    <circle cx="15" cy="10" r="1.2" stroke="currentColor"/>
                                </svg>
                                <span class="text-xs md:text-base text-black">Pet Friendly</span>
                            </div>
                        @endif
                        @if($house->electric_meter)
                            <div class="flex items-left gap-2 md:gap-3 justify-left md:justify-start">
                                <!-- Electric Meter Icon -->
                                <svg class="w-5 h-5 md:w-7 md:h-7 text-black" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <polygon points="13 2 3 14 12 14 11 22 21 10 13 10 13 2" stroke="currentColor" fill="none"/>
                                </svg>
                                <span class="text-xs md:text-base text-black">Own Electric Meter</span>
                            </div>
                        @endif
                        @if($house->water_meter)
                            <div class="flex items-left gap-2 md:gap-3 justify-left md:justify-start">
                                <!-- Water Meter Icon -->
                                <svg class="w-5 h-5 md:w-7 md:h-7 text-black" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M12 2C12 2 5 10.5 5 15a7 7 0 0 0 14 0C19 10.5 12 2 12 2Z" stroke="currentColor"/>
                                    <ellipse cx="12" cy="17" rx="3" ry="2" fill="currentColor" fill-opacity="0.2"/>
                                </svg>
                                <span class="text-xs md:text-base text-black">Own Water Meter</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Location & Neighborhood -->
                <div class="bg-white rounded-xl shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Location & Neighborhood</h2>
                    <p class="text-gray-700 mb-4">Located in the vibrant Quezon City area, this property is surrounded by excellent dining options, shopping centers, and entertainment venues.</p>
                    @if($house->latitude && $house->longitude)
                        <div class="w-full h-96 rounded mb-2" id="map-{{ $house->id }}"></div>
                        @push('scripts')
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                if (document.getElementById('map-{{ $house->id }}')) {
                                    let map = L.map('map-{{ $house->id }}').setView([{{ $house->latitude }}, {{ $house->longitude }}], 15);
                                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                        attribution: '© OpenStreetMap contributors'
                                    }).addTo(map);
                                    L.marker([{{ $house->latitude }}, {{ $house->longitude }}]).addTo(map);
                                    setTimeout(() => { map.invalidateSize(); }, 200);
                                }
                            });
                        </script>
                        @endpush
                    @else
                        <div class="h-96 bg-gray-200 rounded-lg flex items-center justify-center text-gray-500">
                            Location not available
                        </div>
                    @endif
                </div>

                <!-- House Rules -->
                <div class="bg-white rounded-xl shadow p-6 w-full">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">House Rules</h2>
                    @if(!empty($house->rules))
                        <ul class="list-disc pl-6 space-y-2 text-gray-700">
                            @foreach(explode("\n", $house->rules) as $rule)
                                @if(trim($rule) !== '')
                                    <li>{{ $rule }}</li>
                                @endif
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500">No house rules provided.</p>
                    @endif
                </div>
            </div>

        <!-- Section 6: Rental Component (Right Sidebar) -->
        <div class="w-full lg:col-span-2 flex flex-col gap-4 md:gap-6 items-center">
            <!-- Desktop: sticky/floating sidebar -->
            <div 
                class="hidden md:block lg:block bg-white rounded-xl shadow p-3 md:p-6 sticky top-4 md:top-8 w-full max-w-md md:max-w-sm mx-auto z-10 self-start"
            >
                <h2 class="text-base md:text-lg font-semibold text-black mb-2 md:mb-3 text-center md:text-left">Rent this property</h2>
                <div class="flex justify-center md:justify-start">
                    <div class="w-full">
                        @livewire('house-rentals', [
                            'house' => $house,
                        ])
                    </div>
                </div>
            </div>
            <!-- Mobile & Tablet Bottom Bar -->
            <div 
                x-data="{ open: false }"
                class="fixed md:fixed lg:hidden bottom-0 left-0 right-0 z-40"
            >
                <div class="bg-white border-t shadow-lg flex items-center justify-between px-2 py-2">
                    <div>
                        <span class="text-green-600 font-bold text-base">₱{{ number_format($house->price, 2) }}</span>
                        <span class="text-gray-500 text-xs">/day</span>
                    </div>
                    <button 
                        @click="open = !open"
                        class="px-3 py-2 bg-fuchsia-700 text-white rounded-md font-semibold shadow hover:bg-fuchsia-800 focus:outline-none focus:ring-2 focus:ring-fuchsia-500 transition text-sm"
                    >
                        {{ __('Rent Now') }}
                    </button>
                </div>
                <div 
                    x-show="open"
                    x-transition
                    class="bg-white border-t shadow-lg p-2"
                >
                    <div class="flex justify-between items-center mb-2">
                        <span class="font-semibold text-fuchsia-700 text-base">Rent this property</span>
                        <button @click="open = false" class="text-gray-500 hover:text-gray-700 text-xl">&times;</button>
                    </div>
                    <div class="w-full">
                        @livewire('house-rentals', [
                            'house' => $house,
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>