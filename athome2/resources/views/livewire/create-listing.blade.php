<div class="mb-4 p-4 bg-white rounded">
    <div class="max-w-4xl mx-auto p-6 bg-white rounded-lg">
        <form wire:submit.prevent="save">
            <!-- Step 1: House Name & Type -->
            @if ($currentStep == 1)
                <div class="space-y-6 pt-16">
                    <h3 class="text-2xl font-semibold text-gray-800 mb-2">Tell us what kind of place you want to rent</h3>
                    
                    <!-- House Name -->
                   <div>
                        <label for="houseName" class="block text-sm font-medium text-gray-700 mb-1 pt-8">Property Name</label>
                        <input
                            type="text"
                            wire:model="houseName"
                            id="houseName"
                            placeholder="Enter property name"
                            class="w-full px-0 py-2 border-0 border-b border-gray-300 focus:border-fuchsia-700 focus:ring-0 text-lg bg-transparent placeholder-gray-400 transition"
                            autocomplete="off"
                        >
                        @error('houseName')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- House Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2 pt-6">Property Type</label>
                        <div class="flex flex-wrap gap-3">
                            <!-- Studio Type -->
                            <button type="button"
                                wire:click="$set('housetype', 'Studio Type')"
                                class="flex items-center px-6 py-4 text-base rounded-xl border transition-all duration-200
                                    {{ $housetype === 'Studio Type' ? 'border-fuchsia-700 border-2 bg-white text-fuchsia-700 shadow' : 'bg-white text-gray-700 border-gray-300 hover:border-fuchsia-700 border-2' }}">
                                <svg class="w-7 h-7 mr-3 transition-transform duration-200 {{ $housetype === 'Studio Type' ? 'scale-125 text-fuchsia-700' : '' }}"
                            fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <!-- Head -->
                            <circle cx="12" cy="9" r="3" stroke="{{ $housetype === 'Studio Type' ? '#A21CAF' : 'currentColor' }}" />
                            <!-- Shoulders/body -->
                            <path d="M6 19c0-2.5 3-4 6-4s6 1.5 6 4" stroke="{{ $housetype === 'Studio Type' ? '#A21CAF' : 'currentColor' }}" />
                        </svg>
                                Studio Type
                            </button>
                            <!-- One Bedroom -->
                            <button type="button"
                                wire:click="$set('housetype', 'One Bedroom')"
                                class="flex items-center px-6 py-4 text-base rounded-xl border transition-all duration-200
                                    {{ $housetype === 'One Bedroom' ? 'border-fuchsia-700 border-2 bg-white text-fuchsia-700 shadow' : 'bg-white text-gray-700 border-gray-300 hover:border-fuchsia-700 border-2' }}">
                                <svg class="w-7 h-7 mr-3 transition-transform duration-200 {{ $housetype === 'One Bedroom' ? 'scale-125 text-fuchsia-700' : '' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <rect x="3" y="10" width="18" height="7" rx="2" stroke="{{ $housetype === 'One Bedroom' ? '#A21CAF' : 'currentColor' }}"/>
                                    <path d="M7 10V7a2 2 0 0 1 4 0v3" stroke="{{ $housetype === 'One Bedroom' ? '#A21CAF' : 'currentColor' }}"/>
                                </svg>
                                One Bedroom
                            </button>
                            <!-- Two Bedroom -->
                            <button type="button"
                                wire:click="$set('housetype', 'Two Bedroom')"
                                class="flex items-center px-6 py-4 text-base rounded-xl border transition-all duration-200
                                    {{ $housetype === 'Two Bedroom' ? 'border-fuchsia-700 border-2 bg-white text-fuchsia-700 shadow' : 'bg-white text-gray-700 border-gray-300 hover:border-fuchsia-700 border-2' }}">
                                <svg class="w-7 h-7 mr-3 transition-transform duration-200 {{ $housetype === 'Two Bedroom' ? 'scale-125 text-fuchsia-700' : '' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <rect x="3" y="10" width="18" height="7" rx="2" stroke="{{ $housetype === 'Two Bedroom' ? '#A21CAF' : 'currentColor' }}"/>
                                    <path d="M7 10V7a2 2 0 0 1 4 0v3M13 10V7a2 2 0 0 1 4 0v3" stroke="{{ $housetype === 'Two Bedroom' ? '#A21CAF' : 'currentColor' }}"/>
                                </svg>
                                Two Bedroom
                            </button>
                            <!-- Condo -->
                            <button type="button"
                                wire:click="$set('housetype', 'Condo')"
                                class="flex items-center px-6 py-4 text-base rounded-xl border transition-all duration-200
                                    {{ $housetype === 'Condo' ? 'border-fuchsia-700 border-2 bg-white text-fuchsia-700 shadow' : 'bg-white text-gray-700 border-gray-300 hover:border-fuchsia-700 border-2' }}">
                                <svg class="w-7 h-7 mr-3 transition-transform duration-200 {{ $housetype === 'Condo' ? 'scale-125 text-fuchsia-700' : '' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <rect x="4" y="4" width="16" height="16" rx="2" stroke="{{ $housetype === 'Condo' ? '#A21CAF' : 'currentColor' }}"/>
                                    <path d="M9 8h1M9 12h1M9 16h1M14 8h1M14 12h1M14 16h1" stroke="{{ $housetype === 'Condo' ? '#A21CAF' : 'currentColor' }}"/>
                                </svg>
                                Condo
                            </button>
                            <!-- Townhouse -->
                            <button type="button"
                                wire:click="$set('housetype', 'Townhouse')"
                                class="flex items-center px-6 py-4 text-base rounded-xl border transition-all duration-200
                                    {{ $housetype === 'Townhouse' ? 'border-fuchsia-700 border-2 bg-white text-fuchsia-700 shadow' : 'bg-white text-gray-700 border-gray-300 hover:border-fuchsia-700 border-2' }}">
                                <svg class="w-7 h-7 mr-3 transition-transform duration-200 {{ $housetype === 'Townhouse' ? 'scale-125 text-fuchsia-700' : '' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <rect x="3" y="10" width="6" height="8" rx="1" stroke="{{ $housetype === 'Townhouse' ? '#A21CAF' : 'currentColor' }}"/>
                                    <rect x="9" y="6" width="6" height="12" rx="1" stroke="{{ $housetype === 'Townhouse' ? '#A21CAF' : 'currentColor' }}"/>
                                    <rect x="15" y="12" width="6" height="6" rx="1" stroke="{{ $housetype === 'Townhouse' ? '#A21CAF' : 'currentColor' }}"/>
                                </svg>
                                Townhouse
                            </button>
                            <!-- Penthouse -->
                            <button type="button"
                                wire:click="$set('housetype', 'Penthouse')"
                                class="flex items-center px-6 py-4 text-base rounded-xl border transition-all duration-200
                                    {{ $housetype === 'Penthouse' ? 'border-fuchsia-700 border-2 bg-white text-fuchsia-700 shadow' : 'bg-white text-gray-700 border-gray-300 hover:border-fuchsia-700 border-2' }}">
                                <svg class="w-7 h-7 mr-3 transition-transform duration-200 {{ $housetype === 'Penthouse' ? 'scale-125 text-fuchsia-700' : '' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M3 17l3-9 6 6 6-6 3 9" stroke="{{ $housetype === 'Penthouse' ? '#A21CAF' : 'currentColor' }}"/>
                                    <rect x="4" y="17" width="16" height="3" rx="1" stroke="{{ $housetype === 'Penthouse' ? '#A21CAF' : 'currentColor' }}"/>
                                </svg>
                                Penthouse
                            </button>
                        </div>
                        @error('housetype')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            @endif

            <!-- Step 2: Number Counters -->
            @if ($currentStep == 2)
                <div>
                    <h3 class="text-2xl font-semibold text-gray-800 mb-1 pt-16">Share some details about your place</h3>
                    <p class="text-gray-500 mb-2 pb-8">You can change all these information later.</p>
                    <!-- Counter Row Component -->
                    @php
                        $counters = [
                            [
                                'label' => 'Guests',
                                'field' => 'total_occupants',
                                'value' => $total_occupants ?? 1,
                            ],
                            [
                                'label' => 'Bedrooms',
                                'field' => 'total_rooms',
                                'value' => $total_rooms ?? 1,
                            ],

                            [
                                'label' => 'Bathrooms',
                                'field' => 'total_bathrooms',
                                'value' => $total_bathrooms ?? 1,
                            ],
                        ];
                    @endphp

                    @foreach($counters as $counter)
                        <div class="flex items-center justify-between py-4 border-b">
                            <div class="text-lg text-gray-900 font-medium">{{ $counter['label'] }}</div>
                            <div class="flex items-center gap-3">
                                <button type="button"
                                    wire:click="decrement('{{ $counter['field'] }}')"
                                    class="w-10 h-10 flex items-center justify-center rounded-full border border-gray-400 text-2xl text-gray-700 bg-white hover:bg-gray-100 focus:outline-none transition">
                                    &minus;
                                </button>
                                <span class="w-8 text-center text-lg text-gray-900 select-none">{{ $counter['value'] }}</span>
                                <button type="button"
                                    wire:click="increment('{{ $counter['field'] }}')"
                                    class="w-10 h-10 flex items-center justify-center rounded-full border border-gray-400 text-2xl text-gray-700 bg-white hover:bg-gray-100 focus:outline-none transition">
                                    &#43;
                                </button>
                            </div>
                        </div>
                        @if($counter['field'] === 'total_occupants')
                            @error('total_occupants')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        @elseif($counter['field'] === 'total_rooms')
                            @error('total_rooms')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        @elseif($counter['field'] === 'total_bathrooms')
                            @error('total_bathrooms')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        @endif
                    @endforeach
                </div>
            @endif

            <!-- Step 3: Address -->
            @if ($currentStep == 3)
                
                <h3 class="text-2xl font-semibold text-gray-800 mb-1">Address Information</h3>
                <p class="text-gray-500 mb-2 pb-8">Tell us where your place is located.</p>

                    <!-- Street -->
                <div class="space-y-6">
                        <div>
                            <label for="street" class="block text-sm font-medium text-gray-700">House no./Building no., Street/Subdivision</label>
                            <input type="text" wire:model="street" id="street" placeholder="Enter street address"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-fuchsia-500">
                            @error('street')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Region -->
                        <div>
                            <label for="selectedRegion" class="block text-sm font-medium text-gray-700">Region</label>
                            <select wire:model="selectedRegion" id="selectedRegion"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-fuchsia-500">
                                <option class="text-gray-500" value="">Select Region</option>
                                @foreach($regions as $region)
                                    <option value="{{ $region['code'] }}">{{ $region['name'] }}</option>
                                @endforeach
                            </select>
                            @error('selectedRegion')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                            <div wire:loading wire:target="selectedRegion" class="text-sm text-gray-500 mt-1">
                                Loading provinces...
                            </div>
                        </div>

                    <!-- Province (hide only if NCR is selected) -->
                    @if($selectedRegion !== '130000000')
                        <div>
                            <label for="selectedProvince" class="block text-sm font-medium text-gray-700">Province</label>
                            <select wire:model="selectedProvince" id="selectedProvince"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-fuchsia-500"
                                    {{ empty($provinces) ? 'disabled' : '' }}>
                                    <option value="">Select Province</option>
                                @foreach($provinces as $province)
                                    <option value="{{ $province['code'] }}">{{ $province['name'] }}</option>
                                @endforeach
                            </select>
                            @error('selectedProvince')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                            @if($loadingProvinces)
                                <p class="text-sm text-gray-500 mt-1">Loading provinces...</p>
                            @endif
                        </div>
                    @else
                        <!-- Show province info for NCR -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Province</label>
                            <div class="mt-1 block w-full px-3 py-2 border border-gray-200 rounded-md shadow-sm bg-gray-50 text-gray-700">
                                Metro Manila (National Capital Region)
                            </div>
                        </div>
                    @endif

                    <!-- City/Municipality (always show) -->
                    <div>
                        <label for="selectedCity" class="block text-sm font-medium text-gray-700">
                            @if($selectedRegion === '130000000') City/Municipality (NCR)
                            @else City/Municipality
                            @endif
                        </label>
                            <select wire:model="selectedCity" id="selectedCity"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-fuchsia-500"
                                    {{ empty($cities) ? 'disabled' : '' }}>
                                <option value="">Select City/Municipality</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city['code'] }}">{{ $city['name'] }}</option>
                                @endforeach
                            </select>
                        @error('selectedCity')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                        @if($loadingCities)
                            <p class="text-sm text-gray-500 mt-1">Loading cities...</p>
                        @endif
                    </div>

                    <!-- Barangay -->
                    <div>
                        <label for="selectedBarangay" class="block text-sm font-medium text-gray-700">Barangay</label>
                        <select wire:model="selectedBarangay" id="selectedBarangay"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-fuchsia-500"
                                {{ empty($barangays) ? 'disabled' : '' }}>
                            <option value="">Select Barangay</option>
                            @foreach($barangays as $barangay)
                                <option value="{{ $barangay['code'] }}">{{ $barangay['name'] }}</option>
                            @endforeach
                        </select>
                        @error('selectedBarangay')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                        @if($loadingBarangays)
                            <p class="text-sm text-gray-500 mt-1">Loading barangays...</p>
                        @endif
                    </div>
                    
                </div>
            @endif

            <!-- Step 4: Amenities -->
            @if ($currentStep == 4)
                <div class="space-y-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-6">Amenities</h3>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">Amenities</label>
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Air Conditioning -->
                            <button type="button"
                                wire:click="$set('has_aircon', {{ $has_aircon ? 0 : 1 }})"
                                class="flex items-center px-6 py-4 text-base rounded-xl border transition-all duration-200
                                    {{ $has_aircon ? 'border-fuchsia-700 border-2 bg-white text-fuchsia-700 shadow' : 'bg-white text-gray-700 border-gray-300 hover:border-fuchsia-700 border-2' }}">
                                <!-- Aircon Icon -->
                                <svg class="w-7 h-7 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M4 12h9a3 3 0 1 0 0-6 3 3 0 0 0-3 3" stroke="currentColor"/>
                                    <path d="M4 18h13a2 2 0 1 0 0-4 2 2 0 0 0-2 2" stroke="currentColor"/>
                                    <path d="M4 6h5" stroke="currentColor"/>
                                </svg>
                                Air Conditioning
                            </button>
                            <!-- Kitchen (Spatula Icon) -->
                            <button type="button"
                                wire:click="$set('has_kitchen', {{ $has_kitchen ? 0 : 1 }})"
                                class="flex items-center px-6 py-4 text-base rounded-xl border transition-all duration-200
                                    {{ $has_kitchen ? 'border-fuchsia-700 border-2 bg-white text-fuchsia-700 shadow' : 'bg-white text-gray-700 border-gray-300 hover:border-fuchsia-700 border-2' }}">
                                <!-- Spatula Icon -->
                                <svg class="w-7 h-7 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <rect x="5" y="10" width="14" height="7" rx="2" stroke="currentColor"/>
                                <rect x="8" y="7" width="8" height="3" rx="1.5" stroke="currentColor"/>
                                <path d="M3 13h2M19 13h2" stroke="currentColor"/>
                                <path d="M10 7V5M14 7V5" stroke="currentColor"/>
                            </svg>
                                Kitchen
                            </button>
                            <!-- Wi-Fi -->
                            <button type="button"
                                wire:click="$set('has_wifi', {{ $has_wifi ? 0 : 1 }})"
                                class="flex items-center px-6 py-4 text-base rounded-xl border transition-all duration-200
                                    {{ $has_wifi ? 'border-fuchsia-700 border-2 bg-white text-fuchsia-700 shadow' : 'bg-white text-gray-700 border-gray-300 hover:border-fuchsia-700 border-2' }}">
                                <!-- WiFi Icon -->
                                <svg class="w-7 h-7 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M2 8.82a15.91 15.91 0 0 1 20 0M6 13.06a10.94 10.94 0 0 1 12 0M9.91 17.5a4 4 0 0 1 4.18 0" stroke="currentColor"/>
                                    <circle cx="12" cy="20" r="1" fill="currentColor"/>
                                </svg>
                                Wi-Fi
                            </button>
                            <!-- Parking -->
                            <button type="button"
                                wire:click="$set('has_parking', {{ $has_parking ? 0 : 1 }})"
                                class="flex items-center px-6 py-4 text-base rounded-xl border transition-all duration-200
                                    {{ $has_parking ? 'border-fuchsia-700 border-2 bg-white text-fuchsia-700 shadow' : 'bg-white text-gray-700 border-gray-300 hover:border-fuchsia-700 border-2' }}">
                                <!-- Parking Icon -->
                                <svg class="w-7 h-7 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <rect x="4" y="11" width="16" height="5" rx="2" stroke="currentColor"/>
                                    <path d="M7 11V9a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v2" stroke="currentColor"/>
                                    <circle cx="7" cy="18" r="2" stroke="currentColor" fill="none"/>
                                    <circle cx="17" cy="18" r="2" stroke="currentColor" fill="none"/>
                                </svg>
                                Parking
                            </button>
                            <!-- Gym (Dumbbell Icon) -->
                            <button type="button"
                                wire:click="$set('has_gym', {{ $has_gym ? 0 : 1 }})"
                                class="flex items-center px-6 py-4 text-base rounded-xl border transition-all duration-200
                                    {{ $has_gym ? 'border-fuchsia-700 border-2 bg-white text-fuchsia-700 shadow' : 'bg-white text-gray-700 border-gray-300 hover:border-fuchsia-700 border-2' }}">
                                <!-- Dumbbell Icon -->
                                <svg class="w-7 h-7 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <rect x="2" y="10" width="2" height="4" rx="1" stroke="currentColor"/>
                                    <rect x="4" y="8" width="2" height="8" rx="1" stroke="currentColor"/>
                                    <rect x="6" y="11" width="12" height="2" rx="1" stroke="currentColor"/>
                                    <rect x="18" y="8" width="2" height="8" rx="1" stroke="currentColor"/>
                                    <rect x="20" y="10" width="2" height="4" rx="1" stroke="currentColor"/>
                                </svg>
                                Gym
                            </button>
                            <!-- Patio / Balcony -->
                            <button type="button"
                                wire:click="$set('has_patio', {{ $has_patio ? 0 : 1 }})"
                                class="flex items-center px-6 py-4 text-base rounded-xl border transition-all duration-200
                                    {{ $has_patio ? 'border-fuchsia-700 border-2 bg-white text-fuchsia-700 shadow' : 'bg-white text-gray-700 border-gray-300 hover:border-fuchsia-700 border-2' }}">
                                <!-- Patio Icon (Table with umbrella) -->
                                <svg class="w-7 h-7 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <!-- Umbrella -->
                                    <path d="M12 3C7 3 3 7 3 12h18c0-5-4-9-9-9z" stroke="currentColor"/>
                                    <line x1="12" y1="12" x2="12" y2="21" stroke="currentColor"/>
                                    <!-- Table -->
                                    <rect x="8" y="19" width="8" height="2" rx="1" stroke="currentColor"/>
                                </svg>
                                Patio / Balcony
                            </button>
                            <!-- Pool Icon -->
                            <button type="button"
                                wire:click="$set('has_pool', {{ $has_pool ? 0 : 1 }})"
                                class="flex items-center px-6 py-4 text-base rounded-xl border transition-all duration-200
                                    {{ $has_pool ? 'border-fuchsia-700 border-2 bg-white text-fuchsia-700 shadow' : 'bg-white text-gray-700 border-gray-300 hover:border-fuchsia-700 border-2' }}">
                                <!-- Pool Icon (Waves and ladder) -->
                                <svg class="w-7 h-7 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <!-- Water waves -->
                                    <path d="M3 17c1.5 1 3.5 1 5 0s3.5-1 5 0 3.5 1 5 0" stroke="currentColor"/>
                                    <path d="M3 13c1.5 1 3.5 1 5 0s3.5-1 5 0 3.5 1 5 0" stroke="currentColor"/>
                                    <!-- Pool ladder -->
                                    <path d="M7 7v6M17 7v6" stroke="currentColor"/>
                                    <path d="M7 7c0-1.5 2-1.5 2 0v6" stroke="currentColor"/>
                                    <path d="M17 7c0-1.5-2-1.5-2 0v6" stroke="currentColor"/>
                                </svg>
                                Pool
                            </button>
                            <!-- Pet Friendly Icon -->
                            <button type="button"
                                wire:click="$set('is_petfriendly', {{ $is_petfriendly ? 0 : 1 }})"
                                class="flex items-center px-6 py-4 text-base rounded-xl border transition-all duration-200
                                    {{ $is_petfriendly ? 'border-fuchsia-700 border-2 bg-white text-fuchsia-700 shadow' : 'bg-white text-gray-700 border-gray-300 hover:border-fuchsia-700 border-2' }}">
                                <!-- Pet Friendly Icon (Paw) -->
                                <svg class="w-7 h-7 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <!-- Paw pad -->
                                    <ellipse cx="12" cy="17" rx="3" ry="2.5" stroke="currentColor"/>
                                    <!-- Toes -->
                                    <circle cx="7.5" cy="13" r="1.5" stroke="currentColor"/>
                                    <circle cx="16.5" cy="13" r="1.5" stroke="currentColor"/>
                                    <circle cx="9" cy="10" r="1.2" stroke="currentColor"/>
                                    <circle cx="15" cy="10" r="1.2" stroke="currentColor"/>
                                </svg>
                                Pet Friendly
                            </button>
                            <!-- Own Electric Meter (Electricity Icon) -->
                            <button type="button"
                                wire:click="$set('electric_meter', {{ $electric_meter ? 0 : 1 }})"
                                class="flex items-center px-6 py-4 text-base rounded-xl border transition-all duration-200
                                    {{ $electric_meter ? 'border-fuchsia-700 border-2 bg-white text-fuchsia-700 shadow' : 'bg-white text-gray-700 border-gray-300 hover:border-fuchsia-700 border-2' }}">
                                <!-- Electricity Icon -->
                                <svg class="w-7 h-7 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <polygon points="13 2 3 14 12 14 11 22 21 10 13 10 13 2" stroke="currentColor" fill="none"/>
                                </svg>
                                Own Electric Meter
                            </button>
                            <!-- Own Water Meter (Water Drop Icon) -->
                            <button type="button"
                                wire:click="$set('water_meter', {{ $water_meter ? 0 : 1 }})"
                                class="flex items-center px-6 py-4 text-base rounded-xl border transition-all duration-200
                                    {{ $water_meter ? 'border-fuchsia-700 border-2 bg-white text-fuchsia-700 shadow' : 'bg-white text-gray-700 border-gray-300 hover:border-fuchsia-700 border-2' }}">
                                <!-- Water Drop Icon -->
                                <svg class="w-7 h-7 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M12 2C12 2 5 10.5 5 15a7 7 0 0 0 14 0C19 10.5 12 2 12 2Z" stroke="currentColor"/>
                                    <ellipse cx="12" cy="17" rx="3" ry="2" fill="currentColor" fill-opacity="0.2"/>
                                </svg>
                                Own Water Meter
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Step 5: Description and Price -->
            @if ($currentStep == 5)
                <div class="space-y-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-6">Description & Pricing</h3>
                    
                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea wire:model="description" id="description" rows="6" placeholder="Describe your property..."
                                  class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-fuchsia-500"></textarea>
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
                                   class="block w-full pl-8 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-fuchsia-500">
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
                                    @if($has_aircon) <span class="bg-fuchsia-100 text-fuchsia-800 px-2 py-1 rounded-full text-xs">Air Conditioning</span> @endif
                                    @if($has_kitchen) <span class="bg-fuchsia-100 text-fuchsia-800 px-2 py-1 rounded-full text-xs">Kitchen</span> @endif
                                    @if($has_wifi) <span class="bg-fuchsia-100 text-fuchsia-800 px-2 py-1 rounded-full text-xs">Wi-Fi</span> @endif
                                    @if($has_parking) <span class="bg-fuchsia-100 text-fuchsia-800 px-2 py-1 rounded-full text-xs">Parking</span> @endif
                                    @if($has_gym) <span class="bg-fuchsia-100 text-fuchsia-800 px-2 py-1 rounded-full text-xs">Gym</span> @endif
                                    @if($electric_meter) <span class="bg-fuchsia-100 text-fuchsia-800 px-2 py-1 rounded-full text-xs">Own Electric Meter</span> @endif
                                    @if($water_meter) <span class="bg-fuchsia-100 text-fuchsia-800 px-2 py-1 rounded-full text-xs">Own Water Meter</span> @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Navigation Buttons -->
            <div class="flex justify-between mt-8 pt-6">
                <div>
                    @if ($currentStep > 1)
                        <button type="button" wire:click="previousStep"
                                class="px-6 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
                            Previous
                        </button>
                    @endif
                </div>

                <div>
    @if ($currentStep < 5)
        <button type="button" wire:click="nextStep"
                wire:loading.attr="disabled"
                class="px-6 py-2 bg-fuchsia-700 text-white rounded-md hover:bg-fuchsia-800 focus:outline-none focus:ring-2 focus:ring-fuchsia-500 disabled:opacity-50 transition">
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