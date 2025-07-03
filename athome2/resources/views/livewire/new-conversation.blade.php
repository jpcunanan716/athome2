<div>
    <div x-data="{ open: @entangle('showModal') }">
        <!-- Trigger handled by parent component -->
        
        <!-- Modal -->
        <div x-show="open" 
             class="fixed inset-0 z-50 overflow-y-auto" 
             style="display: none;"
             x-on:openNewConversationModal.window="open = true">
             
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                     x-on:click="open = false"></div>
                     
                <div class="relative bg-white rounded-lg max-w-md w-full p-6">
                    <h3 class="text-lg font-medium mb-4">Start New Conversation</h3>
                    
                    <form wire:submit.prevent="startConversation">
                        @if(!$houseId)
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Property</label>
                                <select wire:model="houseId" class="w-full border border-gray-300 rounded-md px-3 py-2">
                                    <option value="">Select a property</option>
                                    @foreach($houses as $house)
                                        <option value="{{ $house->id }}">{{ $house->name }}</option>
                                    @endforeach
                                </select>
                                @error('houseId') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        @endif
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                            <input type="text" 
                                   wire:model="subject" 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2" 
                                   placeholder="Enter subject">
                            @error('subject') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Recipients</label>
                            <div class="border border-gray-300 rounded-md p-2 max-h-40 overflow-y-auto">
                                @foreach($users->where('id', '!=', auth()->id()) as $user)
                                    <label class="flex items-center py-1">
                                        <input type="checkbox" 
                                               wire:model="selectedUsers" 
                                               value="{{ $user->id }}" 
                                               class="mr-2">
                                        {{ $user->name }}
                                    </label>
                                @endforeach
                            </div>
                            @error('selectedUsers') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                            <textarea wire:model="message" 
                                      class="w-full border border-gray-300 rounded-md px-3 py-2" 
                                      rows="3" 
                                      placeholder="Type your message"></textarea>
                            @error('message') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="flex justify-end space-x-2">
                            <button type="button" 
                                    x-on:click="open = false" 
                                    class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                                Cancel
                            </button>
                            <button type="submit" 
                                    class="px-4 py-2 bg-fuchsia-500 text-white rounded-md hover:bg-fuchsia-600">
                                Start Conversation
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('livewire:load', function () {
            Livewire.on('openNewConversationModal', (houseId) => {
                @this.openModal(houseId);
            });
        });
    </script>
</div>