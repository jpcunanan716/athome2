<div>
    @if($showForm)
        <div class="mt-4 p-4 border rounded-lg">
            <p class="text-sm text-gray-600 mb-2">Contact the host about this property</p>
            <button wire:click="startConversation" 
                    class="w-full bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Send Message
            </button>
        </div>
    @else
        <button wire:click="$set('showForm', true)"
                class="mt-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 w-full">
            Contact Host
        </button>
    @endif
</div>