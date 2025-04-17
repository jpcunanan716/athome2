<div class="flex flex-col h-full">
    <!-- Header -->
    <div class="p-4 border-b flex items-center space-x-3">
        <img class="h-10 w-10 rounded-full" 
             src="{{ $conversation->otherParticipant->profile_photo_url }}" 
             alt="{{ $conversation->otherParticipant->name }}">
        <div>
            <h3 class="font-medium">{{ $conversation->otherParticipant->name }}</h3>
            <p class="text-sm text-gray-500">{{ $conversation->House->housename }}</p>
        </div>
    </div>
    
    <!-- Messages -->
    <div class="flex-1 p-4 overflow-y-auto space-y-4" id="messages-container">
        @foreach($messages as $message)
            <div class="flex {{ $message->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-xs lg:max-w-md px-4 py-2 rounded-lg 
                    {{ $message->sender_id == auth()->id() ? 'bg-blue-500 text-white' : 'bg-gray-200' }}">
                    <p>{{ $message->content }}</p>
                    <p class="text-xs mt-1 {{ $message->sender_id == auth()->id() ? 'text-blue-100' : 'text-gray-500' }}">
                        {{ $message->created_at->format('h:i A') }}
                        @if($message->sender_id == auth()->id() && $message->read_at)
                            • Read
                        @endif
                    </p>
                </div>
            </div>
        @endforeach
        
        @if($isTyping)
            <div class="flex justify-start">
                <div class="px-4 py-2 bg-gray-200 rounded-lg">
                    <p class="text-sm italic">{{ $typingUser->name }} is typing...</p>
                </div>
            </div>
        @endif
    </div>
    
    <!-- Input -->
    <div class="p-4 border-t">
        <form wire:submit.prevent="sendMessage">
            <div class="flex space-x-2">
                <input 
                    wire:model="newMessage"
                    wire:keydown.enter.prevent="sendMessage"
                    wire:keydown="emitTyping"
                    type="text" 
                    placeholder="Type your message..."
                    class="flex-1 border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                <button 
                    type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition"
                >
                    Send
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Auto-scroll to bottom
    document.addEventListener('livewire:load', function() {
        scrollToBottom();
    });

    Livewire.on('messageReceived', () => {
        scrollToBottom();
    });

    document.addEventListener('DOMContentLoaded', function() {
        Livewire.on('message-sent', () => {
            scrollToBottom();
        });
    });

    function scrollToBottom() {
        const container = document.getElementById('messages-container');
        container.scrollTop = container.scrollHeight;
    }
    
    // Typing indicator timeout
    document.addEventListener('livewire:load', function() {
        window.addEventListener('reset-typing', (e) => {
            setTimeout(() => {
                Livewire.emit('resetTyping');
            }, e.detail.duration);
        });
    });
</script>
@endpush