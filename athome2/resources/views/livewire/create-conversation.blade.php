<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-6">Start New Conversation</h2>
                    
                    <form wire:submit.prevent="startConversation">
                        <div class="grid grid-cols-1 gap-6">
                            <!-- Property Selection -->
                            <div>
                                <label for="house" class="block text-sm font-medium text-gray-700">Property</label>
                                <select
                                    id="house"
                                    wire:model="houseId"
                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                                    {{ $houseId ? 'disabled' : '' }}
                                >
                                    <option value="">Select a property</option>
                                    @foreach($houses as $house)
                                        <option value="{{ $house->id }}">{{ $house->name ?? 'Property #' . $house->id }}</option>
                                    @endforeach
                                </select>
                                @error('houseId') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

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

                            <!-- Recipients -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Recipients</label>
                                <div class="border border-gray-300 rounded-md p-3 max-h-60 overflow-y-auto">
                                    @foreach($users as $user)
                                        <label class="inline-flex items-center py-1 px-2 mr-2 mb-2 bg-gray-100 rounded">
                                            <input
                                                type="checkbox"
                                                wire:model="selectedUsers"
                                                value="{{ $user->id }}"
                                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"
                                            >
                                            <span class="ml-2 text-sm">{{ $user->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('selectedUsers') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
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