<div>
        <div class="max-w-2xl mx-auto p-6 bg-white shadow-xl rounded-lg">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Create a New House</h2>
            <form wire:submit.prevent="save" class="space-y-6">
                <!-- House Name -->
                <div>
                    <label for="houseName" class="block text-sm font-medium text-gray-700">House Name</label>
                    <input type="text" wire:model="houseName" id="houseName" placeholder="Enter house name"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                @error('houseName')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror

                <!-- House Type -->
                <div x-data="{ housetype: '' }">
                    <label for="housetype" class="block text-sm font-medium text-gray-700">House Type</label>
                    <select wire:model="housetype" id="housetype" x-model="housetype"
                            @change="if (housetype === '') { housetype = ''; $wire.set('housetype', ''); }"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="" disabled selected>Select House Type</option>
                        <option value="Studio Type">Studio Type</option>
                        <option value="One Bedroom">One Bedroom</option>
                        <option value="Two bedroom">Two Bedroom</option>
                        <option value="Condo">Condo</option>
                        <option value="Townhouse">Townhouse</option>
                        <option value="Penthouse">Penthouse</option>
                    </select>
                    @error('housetype')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                                <!-- Street -->
                <div>
                    <label for="street" class="block text-sm font-medium text-gray-700">House no./Building no., Street/Subdivision</label>
                    <input type="text" wire:model="street" id="street" placeholder="Enter street"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                @error('street')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror

 
                <!-- Barangay -->               
                <div>
                    <label for="barangay" class="block text-sm font-medium text-gray-700">Barangay/Village</label>
                    <input type="text" wire:model="barangay" id="barangay" placeholder="Enter barangay"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                @error('barangay')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror

                <!-- City -->
                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700">City/Municipality</label>
                    <input type="text" wire:model="city" id="city" placeholder="Enter city"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                @error('city')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror

                 <!-- Province -->
                 <div>
                    <label for="province" class="block text-sm font-medium text-gray-700">Province</label>
                    <input type="text" wire:model="province" id="province" placeholder="Enter province"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                @error('province')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror

                <!-- Total Occupants -->
                <div>
                    <label for="total_occupants" class="block text-sm font-medium text-gray-700">Maximum Numver of Occupants</label>
                    <input type="text" wire:model="total_occupants" id="total_occupants" placeholder="Enter Total Occupants"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                @error('total_occupants')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror

                <!-- Total Rooms -->
                <div>
                    <label for="total_rooms" class="block text-sm font-medium text-gray-700">Total Room(s)</label>
                    <input type="number" wire:model="total_rooms" id="total_rooms" placeholder="Enter total rooms"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                @error('total_rooms')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror

                <!-- Total Bathrooms -->
                <div>
                    <label for="total_bathrooms" class="block text-sm font-medium text-gray-700">Total Bathroom(s)</label>
                    <input type="number" wire:model="total_bathrooms" id="total_bathrooms" placeholder="Enter total bathrooms"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                @error('total_bathrooms')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea wire:model="description" id="description" placeholder="Enter description"
                              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>
                @error('description')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror

                <!-- Amenities -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Amenities</label>
                    <div class="mt-2 space-y-2">
                        <label class="inline-flex items-center">
                            <input type="checkbox" wire:model="has_aircon" class="form-checkbox h-5 w-5 text-blue-600">
                            <span class="ml-2 text-gray-700">Air Conditioning</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" wire:model="has_kitchen" class="form-checkbox h-5 w-5 text-blue-600">
                            <span class="ml-2 text-gray-700">Kitchen</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" wire:model="has_wifi" class="form-checkbox h-5 w-5 text-blue-600">
                            <span class="ml-2 text-gray-700">Wi-Fi</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" wire:model="has_parking" class="form-checkbox h-5 w-5 text-blue-600">
                            <span class="ml-2 text-gray-700">Parking</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" wire:model="has_gym" class="form-checkbox h-5 w-5 text-blue-600">
                            <span class="ml-2 text-gray-700">Gym</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" wire:model="electric_meter" class="form-checkbox h-5 w-5 text-blue-600">
                            <span class="ml-2 text-gray-700">Own Electric Meter</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" wire:model="water_meter" class="form-checkbox h-5 w-5 text-blue-600">
                            <span class="ml-2 text-gray-700">Own Water Meter</span>
                        </label>
                        
                    </div>
                </div>

                <!-- Price -->
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                    <input type="number" wire:model="price" id="price" placeholder="Enter price"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                @error('price')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror

                <!-- Submit Button -->
                <div>
                    <button type="submit"
                            wire:click="save"
                            wire:loading.attr="disabled"
                            class="w-full bg-blue-500 text-black px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <span wire:loading.remove>Save</span>
                        <span wire:loading>Saving...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>