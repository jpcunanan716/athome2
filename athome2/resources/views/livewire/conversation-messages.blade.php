<div>
    <div class="bg-white shadow rounded-lg">
        <div class="border-b px-4 py-3">
            <h2 class="text-lg font-semibold">{{ $conversation->subject }}</h2>
            <div class="text-sm text-gray-500">
                Property: {{ $conversation->house->houseName ?? 'Unknown' }} | 
                Participants: {{ $conversation->users->pluck('name')->join(', ') }}
            </div>
        </div>
        
        <div class="p-4 h-96 overflow-y-auto" id="messages-container">
            @foreach($messages as $message)
                <div class="mb-4 {{ $message->user_id === auth()->id() ? 'text-right' : '' }}">
                    <div class="inline-block rounded-lg px-4 py-2 {{ $message->user_id === auth()->id() ? 'bg-fuchsia-100' : 'bg-gray-100' }}">
                        <div class="font-medium text-sm {{ $message->user_id === auth()->id() ? 'text-fuchsia-800' : 'text-gray-800' }}">
                            {{ $message->user->name }}
                        </div>
                        <div class="text-sm">{{ $message->content }}</div>
                        <div class="text-xs text-gray-500 mt-1">
                            {{ $message->created_at->format('M j, g:i a') }}
                        </div>
                    </div>
                </div>
            @endforeach
            
            <div id="end-of-messages"></div>
        </div>
        
        <div class="border-t p-4">
            <form wire:submit.prevent="sendMessage">
                <div class="flex">
                    <input type="text" 
                           wire:model.defer="messageText" 
                           class="flex-1 rounded-l border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-fuchsia-500" 
                           placeholder="Type your message..."
                           autocomplete="off">
                    <button type="submit" 
                            class="bg-fuchsia-500 text-white px-4 py-2 rounded-r hover:bg-fuchsia-600 focus:outline-none focus:ring-2 focus:ring-fuchsia-500">
                        Send
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        // Scroll to bottom of messages when new messages arrive
        document.addEventListener('livewire:load', function () {
            const container = document.getElementById('messages-container');
            const scrollToBottom = () => {
                const end = document.getElementById('end-of-messages');
                if (end) {
                    end.scrollIntoView({ behavior: 'smooth' });
                }
            };
            
            scrollToBottom();
            
            Livewire.hook('message.processed', (message, component) => {
                if (component.id === @this.id) {
                    scrollToBottom();
                }
            });
        });
    </script>
</div>