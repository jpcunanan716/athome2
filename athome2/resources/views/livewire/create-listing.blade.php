<div class="mb-4 p-4 bg-fuchsia-100 border border-fuchsia-300 rounded">
    <div class="max-w-4xl mx-auto p-6 bg-white shadow-xl rounded-lg">
        <h2 class="text-3xl font-bold mb-8 text-gray-800 text-center">Create a New House Listing</h2>
        
        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                @for ($i = 1; $i <= $totalSteps; $i++)
                    <div class="flex items-center {{ $i < $totalSteps ? 'flex-1' : '' }}">
                        <div class="flex items-center justify-center w-10 h-10 rounded-full {{ $currentStep >= $i ? 'bg-fuchsia-700 text-white' : 'bg-gray-200 text-gray-600' }} font-semibold">
                            {{ $i }}
                        </div>
                        <div class="ml-3 text-sm font-medium {{ $currentStep >= $i ? 'text-fuchsia-700' : 'text-gray-500' }}">
                            @if ($i == 1) Basic Info
                            @elseif ($i == 2) Address
                            @else Description & Price
                            @endif
                        </div>
                        @if ($i < $totalSteps)
                            <div class="flex-1 mx-4 h-1 {{ $currentStep > $i ? 'bg-fuchsia-700' : 'bg-gray-200' }} rounded"></div>
                        @endif
                    </div>
                @endfor
            </div>
        </div>

        <form wire:submit.prevent="save">
            <!-- Step 1: Basic Information -->
            @if ($currentStep == 1)
                <div class="space-y-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-6">Basic Information</h3>
                    
                    <!-- House Name -->
                    <div>
                        <label for="houseName" class="block text-sm font-medium text-gray-700">House Name</label>
                        <input type="text" wire:model="houseName" id="houseName" placeholder="Enter house name"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('houseName')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- House Type -->
                    <div>
                        <label for="housetype" class="block text-sm font-medium text-gray-700">House Type</label>
                        <select wire:model="housetype" id="housetype"
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
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Total Occupants -->
                    <div>
                        <label for="total_occupants" class="block text-sm font-medium text-gray-700">Maximum Number of Occupants</label>
                        <input type="number" wire:model="total_occupants" id="total_occupants" placeholder="Enter maximum occupants"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('total_occupants')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Total Rooms -->
                    <div>
                        <label for="total_rooms" class="block text-sm font-medium text-gray-700">Total Room(s)</label>
                        <input type="number" wire:model="total_rooms" id="total_rooms" placeholder="Enter total rooms"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('total_rooms')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Total Bathrooms -->
                    <div>
                        <label for="total_bathrooms" class="block text-sm font-medium text-gray-700">Total Bathroom(s)</label>
                        <input type="number" wire:model="total_bathrooms" id="total_bathrooms" placeholder="Enter total bathrooms"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('total_bathrooms')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Amenities -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">Amenities</label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="flex items-center">
                                <input type="checkbox" wire:model="has_aircon" class="form-checkbox h-5 w-5 text-blue-600 rounded">
                                <span class="ml-2 text-gray-700">Air Conditioning</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" wire:model="has_kitchen" class="form-checkbox h-5 w-5 text-blue-600 rounded">
                                <span class="ml-2 text-gray-700">Kitchen</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" wire:model="has_wifi" class="form-checkbox h-5 w-5 text-blue-600 rounded">
                                <span class="ml-2 text-gray-700">Wi-Fi</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" wire:model="has_parking" class="form-checkbox h-5 w-5 text-blue-600 rounded">
                                <span class="ml-2 text-gray-700">Parking</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" wire:model="has_gym" class="form-checkbox h-5 w-5 text-blue-600 rounded">
                                <span class="ml-2 text-gray-700">Gym</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" wire:model="electric_meter" class="form-checkbox h-5 w-5 text-blue-600 rounded">
                                <span class="ml-2 text-gray-700">Own Electric Meter</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" wire:model="water_meter" class="form-checkbox h-5 w-5 text-blue-600 rounded">
                                <span class="ml-2 text-gray-700">Own Water Meter</span>
                            </label>
                        </div>
                    </div>
                </div>
            @endif

           <!-- Step 2: Address Information -->
@if ($currentStep == 2)
    <div class="space-y-6">
        <h3 class="text-xl font-semibold text-gray-800 mb-6">Address Information</h3>
        
        <!-- Street -->
        <div>
            <label for="street" class="block text-sm font-medium text-gray-700">House no./Building no., Street/Subdivision</label>
            <input type="text" wire:model="street" id="street" placeholder="Enter street address"
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('street')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Region -->
        <div>
            <label for="selectedRegion" class="block text-sm font-medium text-gray-700">Region</label>
            <select wire:model="selectedRegion" id="selectedRegion" wire:change="updatedSelectedRegion($event.target.value)"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Select Region</option>
                @foreach($regions as $region)
                    <option value="{{ $region['code'] }}">{{ $region['name'] }}</option>
                @endforeach
            </select>
            @error('region')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
            <div wire:loading wire:target="selectedRegion" class="text-sm text-gray-500 mt-1">
                Loading provinces...
            </div>
        </div>

        <!-- Province -->
        <div>
            <label for="selectedProvince" class="block text-sm font-medium text-gray-700">Province</label>
            <select wire:model="selectedProvince" id="selectedProvince" wire:change="updatedSelectedProvince($event.target.value)"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    {{ empty($provinces) ? 'disabled' : '' }}>
                <option value="">
                    @if(empty($selectedRegion))
                        Select Region First
                    @elseif(empty($provinces))
                        Loading provinces...
                    @else
                        Select Province
                    @endif
                </option>
                @foreach($provinces as $province)
                    <option value="{{ $province['code'] }}">{{ $province['name'] }}</option>
                @endforeach
            </select>
            @error('province')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
            <div wire:loading wire:target="selectedProvince" class="text-sm text-gray-500 mt-1">
                Loading cities...
            </div>
        </div>

        <!-- City -->
        <div>
            <label for="selectedCity" class="block text-sm font-medium text-gray-700">City/Municipality</label>
            <select wire:model="selectedCity" id="selectedCity" wire:change="updatedSelectedCity($event.target.value)"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    {{ empty($cities) ? 'disabled' : '' }}>
                <option value="">
                    @if(empty($selectedProvince))
                        Select Province First
                    @elseif(empty($cities))
                        Loading cities...
                    @else
                        Select City/Municipality
                    @endif
                </option>
                @foreach($cities as $city)
                    <option value="{{ $city['code'] }}">{{ $city['name'] }}</option>
                @endforeach
            </select>
            @error('city')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
            <div wire:loading wire:target="selectedCity" class="text-sm text-gray-500 mt-1">
                Loading barangays...
            </div>
        </div>

        <!-- Barangay -->
        <div>
            <label for="barangay" class="block text-sm font-medium text-gray-700">Barangay</label>
            <select wire:model="barangay" id="barangay"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    {{ empty($barangays) ? 'disabled' : '' }}>
                <option value="">
                    @if(empty($selectedCity))
                        Select City First
                    @elseif(empty($barangays))
                        Loading barangays...
                    @else
                        Select Barangay
                    @endif
                </option>
                @foreach($barangays as $barangay)
                    <option value="{{ $barangay['name'] }}">{{ $barangay['name'] }}</option>
                @endforeach
            </select>
            @error('barangay')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>
@endif
            <!-- Step 3: Description and Price -->
            @if ($currentStep == 3)
                <div class="space-y-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-6">Description & Pricing</h3>
                    
                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea wire:model="description" id="description" rows="6" placeholder="Describe your property..."
                                  class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                        @error('description')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Price -->
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700">Price (Per Day)</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">₱</span>
                            </div>
                            <input type="number" wire:model="price" id="price" placeholder="0.00"
                                   class="block w-full pl-8 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        @error('price')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Summary Section -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h4 class="text-lg font-medium text-gray-800 mb-4">Property Summary</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div><strong>Name:</strong> {{ $houseName ?? 'Not specified' }}</div>
                            <div><strong>Type:</strong> {{ $housetype ?? 'Not specified' }}</div>
                            <div><strong>Max Occupants:</strong> {{ $total_occupants ?? 'Not specified' }}</div>
                            <div><strong>Rooms:</strong> {{ $total_rooms ?? 'Not specified' }}</div>
                            <div><strong>Bathrooms:</strong> {{ $total_bathrooms ?? 'Not specified' }}</div>
                            <div><strong>Address:</strong> {{ $street ?? 'Not specified' }}, {{ $barangay ?? '' }}, {{ $city ?? '' }}, {{ $province ?? '' }}</div>
                        </div>
                        @if($has_aircon || $has_kitchen || $has_wifi || $has_parking || $has_gym || $electric_meter || $water_meter)
                            <div class="mt-4">
                                <strong>Amenities:</strong>
                                <div class="flex flex-wrap gap-2 mt-2">
                                    @if($has_aircon) <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">Air Conditioning</span> @endif
                                    @if($has_kitchen) <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">Kitchen</span> @endif
                                    @if($has_wifi) <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">Wi-Fi</span> @endif
                                    @if($has_parking) <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">Parking</span> @endif
                                    @if($has_gym) <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">Gym</span> @endif
                                    @if($electric_meter) <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">Own Electric Meter</span> @endif
                                    @if($water_meter) <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">Own Water Meter</span> @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Navigation Buttons -->
            <div class="flex justify-between mt-8 pt-6 border-t border-gray-200">
                <div>
                    @if ($currentStep > 1)
                        <button type="button" wire:click="previousStep"
                                class="px-6 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
                            Previous
                        </button>
                    @endif
                </div>

                <div>
                    @if ($currentStep < $totalSteps)
                        <button type="button" wire:click="nextStep"
                                wire:loading.attr="disabled"
                                class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:opacity-50">
                            <span wire:loading.remove wire:target="nextStep">Next</span>
                            <span wire:loading wire:target="nextStep">Loading...</span>
                        </button>
                    @else
                        <button type="submit"
                                wire:loading.attr="disabled"
                                class="px-8 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 disabled:opacity-50">
                            <span wire:loading.remove wire:target="save">Create Listing</span>
                            <span wire:loading wire:target="save">Creating...</span>
                        </button>
                    @endif
                </div>
            </div>
        </form>

        <!-- Step Navigation (Optional - allows jumping to completed steps) -->
        <div class="mt-6 flex justify-center space-x-2">
            @for ($i = 1; $i <= $totalSteps; $i++)
                <button type="button" 
                        wire:click="goToStep({{ $i }})"
                        class="w-3 h-3 rounded-full {{ $currentStep == $i ? 'bg-blue-600' : ($currentStep > $i ? 'bg-blue-400' : 'bg-gray-300') }}">
                </button>
            @endfor
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Optional: Add some smooth transitions or additional JavaScript functionality
    document.addEventListener('livewire:initialized', () => {
        // You can add custom JavaScript here if needed
    });
</script>
@endpush