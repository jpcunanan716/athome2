<div class="py-12">
    <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <!-- Grid container for cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach ($houses as $house)
                    @if($house->user_id != auth()->id())
                        <div class="block bg-white rounded-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 relative">
                            
                            <!-- Favorite Button -->
                            <button wire:click="toggleFavorite({{ $house->id }})" 
                                    class="absolute top-4 right-4 z-10 p-2 bg-white/20 rounded-full hover:bg-white/60 transition-all"
                                    title="{{ $this->isFavorite($house->id) ? 'Remove from favorites' : 'Add to favorites' }}">
                                @if($this->isFavorite($house->id))
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="red" class="w-6 h-6">
                                        <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="rgba(0, 0, 0, 0.35)" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                    </svg>
                                @endif
                            </button>
                            
                            <!-- Swiper Carousel -->
                            <div wire:ignore>
                            <div class="swiper">
                                <div class="swiper-wrapper">
                                    @foreach ($house->media as $media)
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
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                            </div>

                            <!-- House Details -->
                            <div class="px-8 py-6">
                                <h2 class="text-2xl font-semibold">{{ $house->houseName }}</h2>
                                <p class="text-gray-600 text-lg font-semibold">{{ $house->city }}, {{ $house->province }}</p>
                                <p class="text-gray-700 mt-3 text-lg">Type: {{ $house->housetype }}</p>
                                <p class="text-green-600 font-bold text-xl mt-3">₱{{ number_format($house->price, 2) }} / month</p>
                                <p class="text-sm text-gray-500 mt-1">{{ $house->favorited_by_count }} favorites</p>

                                @if($house->furnished)
                                    <span class="inline-block bg-green-500 text-white px-3 py-1 text-sm rounded mt-3">Furnished</span>
                                @endif

                                <a href="{{ route('house.show', ['houseId' => $house->id]) }}" target="_blank"
                                   class="block text-center bg-violet-800 text-white px-6 py-3 mt-4 rounded hover:bg-violet-500 transition-colors duration-300">
                                    View Details
                                </a>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $houses->links() }}
            </div>
        </div>
    </div>
</div>