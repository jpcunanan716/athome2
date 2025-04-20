<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    @if(isset($users[0]) && isset($houses[0]))
                        <h2 class="text-lg font-medium text-gray-900 mb-2">Start New Conversation with {{ $users[0]->name }}</h2>
                        @if($houseId)
                            <p class="text-sm text-gray-600 mb-6">You are messaging {{ $users[0]->name }} about their "{{ $houses->firstWhere('id', $houseId)->houseName ?? 'Property' }}" listing</p>
                        @endif
                    @else
                        <h2 class="text-lg font-medium text-gray-900 mb-6">Start New Conversation</h2>
                    @endif
                    
                    <form wire:submit.prevent="startConversation">
                        <div class="grid grid-cols-1 gap-6">

                            <!-- Hidden Property Selection -->
                            <input
                                type="hidden"
                                id="house"
                                wire:model="houseId"
                            >
                            @error('houseId') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                            <!-- Hidden Selected Users - Using Livewire's array binding -->
                            @foreach($users as $index => $user)
                                <input 
                                    type="hidden" 
                                    wire:model="selectedUsers.{{ $index }}" 
                                    value="{{ $user->id }}"
                                >
                            @endforeach
                            @error('selectedUsers') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                            <!-- Subject -->
                            <div>
                                <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
                                <input
                                    type="text"
                                    id="subject"
                                    wire:model="subject"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                    placeholder="Enter a subject for this conversation"
                                >
                                @error('subject') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Message -->
                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                                <textarea
                                    id="message"
                                    wire:model="message"
                                    rows="5"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                    placeholder="Type your message here"
                                ></textarea>
                                @error('message') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex justify-end space-x-3">
                                <a
                                    href="{{ route('conversations.index') }}"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                >
                                    Cancel
                                </a>
                                <button
                                    type="submit"
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                >
                                    Start Conversation
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>