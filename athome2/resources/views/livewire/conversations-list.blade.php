<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Conversations</h2>
    </div>
    
    <div class="space-y-4">
        @forelse ($conversations as $conversation)
            <div class="border rounded-lg p-4 hover:bg-gray-50">
                <a href="{{ route('conversations.show', $conversation->id) }}" 
                   wire:click="markAsRead({{ $conversation->id }})"
                   class="block">
                    <div class="flex justify-between">
                        <h3 class="font-medium">
                            {{ $conversation->subject }}
                            
                            @if ($conversation->unreadMessagesForUser(auth()->id()) > 0)
                                <span class="bg-fuchsia-500 text-white text-xs rounded-full px-2 py-1 ml-2">
                                    {{ $conversation->unreadMessagesForUser(auth()->id()) }}
                                </span>
                            @endif
                        </h3>
                        <span class="text-sm text-gray-500">
                            {{ $conversation->updated_at->diffForHumans() }}
                        </span>
                    </div>
                    
                    <div class="text-sm text-gray-500 mt-1">
                        Property: {{ $conversation->house->houseName ?? 'Unknown' }}
                    </div>
                    
                    <div class="text-sm text-gray-500 mt-1">
                        Participants: {{ $conversation->users->pluck('name')->join(', ') }}
                    </div>
                    
                    @if ($conversation->latestMessage)
                        <div class="text-sm mt-2 truncate">
                            <span class="font-medium">{{ $conversation->latestMessage->user->name }}:</span>
                            {{ $conversation->latestMessage->content }}
                        </div>
                    @endif
                </a>
            </div>
        @empty
            <div class="text-center py-8 text-gray-500">
                No conversations yet. Rent a property to start a conversation.
            </div>
        @endforelse
    </div>
    
    <div class="mt-4">
        {{ $conversations->links() }}
    </div>
</div>