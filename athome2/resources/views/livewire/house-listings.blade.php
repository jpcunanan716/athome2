<div class="py-12">
    <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <!-- Grid container for cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach ($houses as $house)
                    @if($house->user_id != auth()->id())
                        <a href="{{ route('house.show', ['houseId' => $house->id]) }}" target="_blank"
                            class="block bg-white rounded-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 relative group focus:outline-none focus:ring-2 focus:ring-fuchsia-700 border-2 border-transparent hover:border-fuchsia-700"
                            style="text-decoration: none;">
                            <!-- Favorite Button -->
                            <button wire:click.stop="toggleFavorite({{ $house->id }})" 
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
                            
                            <!-- Images -->
                            <div wire:ignore>
                                @if($house->media->isNotEmpty())
                                    <div class="w-full h-80 rounded-lg overflow-hidden">
                                        <img src="{{ asset('storage/' . $house->media->first()->image_path) }}"
                                            alt="House Image"
                                            class="w-full h-80 object-cover group-hover:scale-105 transition-transform duration-300">
                                    </div>
                                @endif
                            </div>

                            <!-- House Details -->
                            <div class="px-2 py-6">
                                <h2 class="text-black text-2xl font-semibold">{{ $house->houseName }}</h2>
                                <p class="text-gray-600 font-semibold">{{ $house->housetype }} in {{ $house->city }}</p>
                                <p class="text-green-600 font-bold mt-3">₱{{ number_format($house->price, 2) }} / Day</p>
                                <p class="text-sm text-gray-500 mt-1">{{ $house->favorited_by_count }} favorites</p>

                                @if($house->furnished)
                                    <span class="inline-block bg-green-500 text-white px-3 py-1 text-sm rounded mt-3">Furnished</span>
                                @endif
                            </div>
                        </a>
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