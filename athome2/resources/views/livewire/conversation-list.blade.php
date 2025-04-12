<div class="border-r border-gray-200 h-full overflow-y-auto">
    <div class="p-4 border-b">
        <h2 class="text-lg font-semibold">Messages</h2>
    </div>
    
    <div class="divide-y divide-gray-200">
        @forelse($conversations as $conversation)
            <a href="{{ route('messages.show', $conversation) }}" 
               class="block p-4 hover:bg-gray-50 transition">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        <img class="h-10 w-10 rounded-full" 
                             src="{{ $conversation->otherParticipant->profile_photo_url }}" 
                             alt="{{ $conversation->otherParticipant->name }}">
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">
                            {{ $conversation->otherParticipant->name }}
                        </p>
                        <p class="text-sm text-gray-500 truncate">
                            {{ $conversation->property->title }}
                        </p>
                        @if($conversation->messages->first())
                            <p class="text-xs text-gray-500 mt-1 truncate">
                                {{ Str::limit($conversation->messages->first()->content, 50) }}
                            </p>
                        @endif
                    </div>
                    @if($conversation->unreadCount() > 0)
                        <span class="bg-blue-500 text-white text-xs font-medium px-2 py-0.5 rounded-full">
                            {{ $conversation->unreadCount() }}
                        </span>
                    @endif
                </div>
            </a>
        @empty
            <div class="p-4 text-center text-gray-500">
                No conversations yet
            </div>
        @endforelse
    </div>
</div>