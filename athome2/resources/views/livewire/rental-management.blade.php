<div class="container mx-auto py-6 px-4">
    @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            <p>{{ session('message') }}</p>
        </div>
    @endif

    <!-- Navigation Tabs + New Listing Button -->
    <div class="flex justify-between items-center text-center border-b border-gray-200 mb-6">
        <nav class="-mb-px flex space-x-8">
            <button wire:click="switchTab('rentals')" 
                class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab == 'rentals' 
                    ? 'border-fuchsia-500 text-fuchsia-600' 
                    : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                Rental Requests
            </button>
            <button wire:click="switchTab('properties')" 
                class="py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab == 'properties' 
                    ? 'border-fuchsia-500 text-fuchsia-600' 
                    : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                My Properties
            </button>
        </nav>
        <a href="{{ route('new-listing') }}" target="_blank"
            class="bg-fuchsia-700 hover:bg-fuchsia-600 text-white px-4 py-2 rounded-lg flex items-center ml-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            New Listing
        </a>
    </div>

    <!-- Rental Requests Tab Content -->
    @if ($activeTab == 'rentals')
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Rental Requests</h2>
        </div>

        @if($rentals->isEmpty())
            <div class="bg-white p-6 rounded-lg shadow text-center">
                <p class="text-gray-500">No rental requests for your properties yet.</p>
            </div>
        @else
            <div class="overflow-x-auto bg-white rounded-lg shadow">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Renter</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Property</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dates</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($rentals as $rental)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $rental->user->name }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $rental->house->houseName }}</div>
                                    <div class="text-sm text-gray-500">{{ $rental->house->city }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($rental->start_date)->format('M j, Y') }} - 
                                        {{ \Carbon\Carbon::parse($rental->end_date)->format('M j, Y') }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($rental->start_date)->diffInDays($rental->end_date) }} days
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    ₱{{ number_format($rental->total_price, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if($rental->status == 'approved') bg-green-100 text-green-800
                                        @elseif($rental->status == 'rejected') bg-red-100 text-red-800
                                        @else bg-yellow-100 text-yellow-800 @endif">
                                        {{ ucfirst($rental->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    @if($rental->status == 'pending')
                                        <button wire:click="approve({{ $rental->id }})" 
                                                class="text-green-600 hover:text-green-900 mr-4"
                                                wire:loading.attr="disabled">
                                            Approve
                                        </button>
                                        <button wire:click="reject({{ $rental->id }})" 
                                                class="text-red-600 hover:text-red-900"
                                                wire:loading.attr="disabled">
                                            Reject
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

    <!-- Properties Tab Content -->
    @elseif ($activeTab == 'properties')
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">My Properties</h2>
        </div>

        @if($properties->isEmpty())
            <div class="bg-white p-6 rounded-lg shadow text-center">
                <p class="text-gray-500">You haven't listed any properties yet.</p>
                <a href="{{ route('new-listing') }}" class="inline-block mt-4 text-fuchsia-600 hover:text-fuchsia-800">
                    Create your first listing
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($properties as $property)
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        @if($property->media && $property->media->isNotEmpty())
                            <img src="{{ asset('storage/' . $property->media->first()->image_path) }}" 
                                alt="{{ $property->houseName }}" 
                                class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 22V12h6v10" />
                                </svg>
                            </div>
                        @endif
                        
                        <div class="p-4">
                            <div class="flex justify-between items-start">
                                <h3 class="text-lg font-semibold text-gray-900">{{ $property->houseName }}</h3>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $property->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $property->status ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                            <p class="text-gray-600 mt-1">{{ $property->barangay }}, {{ $property->city }}</p>
                            <p class="text-gray-800 font-medium mt-2">₱{{ number_format($property->price, 2) }} / night</p>
                            
                            <div class="flex items-center mt-3 text-sm text-gray-600">
                                <span class="flex items-center mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                                    </svg>
                                    {{ $property->total_rooms }} room(s)
                                </span>
                                <span class="flex items-center mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ $property->total_bathrooms }} bath(s)
                                </span>
                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                    {{ $property->total_occupants }} guest(s)
                                </span>
                            </div>
                            
                            <!-- Amenities display -->
                            <div class="mt-3 flex flex-wrap gap-2">
                                @if($property->has_aircon)
                                <span class="px-2 py-1 bg-fuchsia-100 text-fuchsia-800 text-xs rounded-full">Air Conditioning</span>
                                @endif
                                @if($property->has_wifi)
                                <span class="px-2 py-1 bg-fuchsia-100 text-fuchsia-800 text-xs rounded-full">WiFi</span>
                                @endif
                                @if($property->has_kitchen)
                                <span class="px-2 py-1 bg-fuchsia-100 text-fuchsia-800 text-xs rounded-full">Kitchen</span>
                                @endif
                                @if($property->has_parking)
                                <span class="px-2 py-1 bg-fuchsia-100 text-fuchsia-800 text-xs rounded-full">Parking</span>
                                @endif
                                @if($property->has_gym)
                                <span class="px-2 py-1 bg-fuchsia-100 text-fuchsia-800 text-xs rounded-full">Gym</span>
                                @endif
                                @if($property->has_patio)
                                <span class="px-2 py-1 bg-fuchsia-100 text-fuchsia-800 text-xs rounded-full">Gym</span>
                                @endif
                                @if($property->has_pool)
                                <span class="px-2 py-1 bg-fuchsia-100 text-fuchsia-800 text-xs rounded-full">Gym</span>
                                @endif
                                @if($property->is_petfriendly)
                                <span class="px-2 py-1 bg-fuchsia-100 text-fuchsia-800 text-xs rounded-full">Gym</span>
                                @endif
                                @if($property->electric_meter)
                                <span class="px-2 py-1 bg-fuchsia-100 text-fuchsia-800 text-xs rounded-full">Own Electric Meter</span>
                                @endif
                                @if($property->water_meter)
                                <span class="px-2 py-1 bg-fuchsia-100 text-fuchsia-800 text-xs rounded-full">Own Water Meter</span>
                                @endif
                            </div>
                            
                            <div class="mt-4 pt-4 border-t border-gray-200 flex space-x-2">
                                <button wire:click="editProperty({{ $property->id }})"
                                    class="bg-white border-2 border-black text-black px-3 py-1 rounded text-sm flex-1 hover:bg-gray-100 transition">
                                    Edit
                                </button>
                                <button wire:click="toggleActive({{ $property->id }})"
                                    class="bg-white px-3 py-1 rounded text-sm flex-1 border-2
                                        {{ $property->status ? 'border-red-500 text-red-600 hover:bg-red-50' : 'border-green-500 text-green-600 hover:bg-green-50' }} transition">
                                    {{ $property->status ? 'Disable Property' : 'Enable Property' }}
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @endif

    <!-- Edit Property Modal -->
    @if($showEditModal)
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full mx-4 max-h-screen overflow-y-auto">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">Edit Property</h3>
                <button wire:click="closeModal" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <div class="px-6 py-4">
                <form wire:submit.prevent="updateProperty">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="houseName" class="block text-sm font-medium text-gray-700">Property Name</label>
                            <input type="text" id="houseName" wire:model="houseName" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @error('houseName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label for="housetype" class="block text-sm font-medium text-gray-700">House Type</label>
                            <input type="text" id="housetype" wire:model="housetype" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @error('housetype') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label for="street" class="block text-sm font-medium text-gray-700">Street</label>
                            <input type="text" id="street" wire:model="street" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @error('street') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label for="province" class="block text-sm font-medium text-gray-700">Province</label>
                            <input type="text" id="province" wire:model="province" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @error('province') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                            <input type="text" id="city" wire:model="city" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @error('city') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label for="barangay" class="block text-sm font-medium text-gray-700">Barangay</label>
                            <input type="text" id="barangay" wire:model="barangay" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @error('barangay') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label for="total_occupants" class="block text-sm font-medium text-gray-700">Max Occupants</label>
                            <input type="number" id="total_occupants" wire:model="total_occupants" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @error('total_occupants') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label for="total_rooms" class="block text-sm font-medium text-gray-700">Total Rooms</label>
                            <input type="number" id="total_rooms" wire:model="total_rooms" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @error('total_rooms') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label for="total_bathrooms" class="block text-sm font-medium text-gray-700">Total Bathrooms</label>
                            <input type="number" id="total_bathrooms" wire:model="total_bathrooms" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @error('total_bathrooms') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700">Price per Night (₱)</label>
                            <input type="number" step="0.01" id="price" wire:model="price" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea id="description" rows="4" wire:model="description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="col-span-2">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Amenities</h4>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                <label class="flex items-center">
                                    <input type="checkbox" wire:model="has_aircon" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700">Air Conditioning</span>
                                </label>
                                
                                <label class="flex items-center">
                                    <input type="checkbox" wire:model="has_kitchen" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700">Kitchen</span>
                                </label>
                                
                                <label class="flex items-center">
                                    <input type="checkbox" wire:model="has_wifi" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700">WiFi</span>
                                </label>
                                
                                <label class="flex items-center">
                                    <input type="checkbox" wire:model="has_parking" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700">Parking</span>
                                </label>
                                
                                <label class="flex items-center">
                                    <input type="checkbox" wire:model="has_gym" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700">Gym</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" wire:model="electric_meter" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700">Own Electric Meter</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" wire:model="water_meter" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700">Own Water Meter</span>
                                </label>
                            </div>
                        </div>

                        
                    </div>
                    
                    <div class="mt-6 flex justify-end space-x-3">
                        <button type="button" wire:click="closeModal" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                            Cancel
                        </button>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                            Update Property
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>