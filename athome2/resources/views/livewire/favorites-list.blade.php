<!-- resources/views/livewire/favorites-list.blade.php -->
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-8">Your Favorite Properties</h1>
        
        @if($favorites->isEmpty())
            <div class="text-center py-12">
                <p class="text-gray-500 text-lg">You haven't favorited any properties yet.</p>
                <a href="{{ route('home') }}" class="mt-4 inline-block bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                    Browse Properties
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($favorites as $house)
                    <div class="py-12">                            
                            @if($favorites->isEmpty())
                                <!-- Empty state -->
                            @else 
                                        <!-- Card HTML directly in the view -->
                                        <div class="block bg-white rounded-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 relative">
                                            <!-- Favorite Button -->
                                            <button wire:click="toggleFavorite({{ $house->id }})" 
                                                    class="absolute top-4 right-4 z-10 p-2 bg-white/80 rounded-full hover:bg-white transition-all">
                                                <!-- Heart SVG (liked state) -->
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="red" class="w-6 h-6">
                                                    <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z"/>
                                                </svg>
                                            </button>

                                            <!-- Carousel -->
                                            <div wire:ignore class="swiper">
                                                <div class="swiper-wrapper">
                                                    @foreach($house->media as $media)
                                                        <div class="swiper-slide">
                                                            <div class="w-full h-80 rounded-lg overflow-hidden">
                                                                <img src="{{ asset('storage/' . $media->image_path) }}" 
                                                                    alt="House Image" 
                                                                    class="w-full h-80 object-cover">
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="swiper-pagination"></div>
                                            </div>

                                            <!-- House Details -->
                                            <div class="p-6">
                                                <h3 class="text-xl font-semibold">{{ $house->houseName }}</h3>
                                                <p class="text-gray-600">{{ $house->city }}, {{ $house->province }}</p>
                                                <p class="text-gray-700 mt-2">₱{{ number_format($house->price, 2) }}/month</p>
                                                <a href="{{ route('house.show', $house->id) }}" 
                                                class="block mt-4 text-center bg-blue-500 text-white py-2 rounded hover:bg-blue-600">
                                                    View Details
                                                </a>
                                            </div>
                                        </div>
                                {{ $favorites->links() }}
                            @endif
                    </div>
                @endforeach
            </div>
            
            <div class="mt-8">
                {{ $favorites->links() }}
            </div>
        @endif
    </div>
</div>