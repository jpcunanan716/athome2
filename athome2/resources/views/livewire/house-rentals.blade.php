<div>
    <div>
        <!-- Guest Count -->
        <div class="mb-4">
            <label class="block text-gray-700">Number of Guests</label>
            <input 
                type="number" 
                wire:model="number_of_guests"
                min="1"
                max="{{ $house->total_occupants }}"
                class="mt-1 block w-full border rounded px-3 py-2"
            >
            @error('number_of_guests')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
            <p class="text-sm text-gray-500 mt-1">
                Maximum occupancy: {{ $house->total_occupants }} guests
            </p>
        </div>

        <!-- Start Date -->
        <div class="mb-4">
            <label class="block text-gray-700">Start Date</label>
            <input 
                type="date" 
                wire:model.live="start_date"
                class="mt-1 block w-full border rounded px-3 py-2"
                min="{{ now()->format('Y-m-d') }}"
                id="start-date-picker"
            >
            @error('start_date')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- End Date -->
        <div class="mb-4">
            <label class="block text-gray-700">End Date</label>
            <input 
                type="date" 
                wire:model.live="end_date"
                class="mt-1 block w-full border rounded px-3 py-2"
                min="{{ $start_date ?? now()->format('Y-m-d') }}"
                id="end-date-picker"
            >
            @error('end_date')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Unavailable Dates Notice -->
        @if(!empty($unavailableDates))
            <div class="mb-4 p-3 bg-yellow-50 border border-yellow-200 rounded">
                <p class="text-sm text-yellow-800">
                    <strong>Note:</strong> Some dates are already booked and unavailable for selection.
                </p>
            </div>
        @endif

        @if($total_price !== null && $start_date && $end_date)
            <div class="mb-4">
                <p class="text-lg font-semibold">Total: ₱{{ number_format($total_price, 2) }}</p>
                <p class="text-sm text-gray-600">
                    For {{ $number_of_guests }} guest(s)<br>
                    {{ Carbon\Carbon::parse($start_date)->format('M j, Y') }} to 
                    {{ Carbon\Carbon::parse($end_date)->format('M j, Y') }}<br>
                    ({{ Carbon\Carbon::parse($start_date)->diffInDays(Carbon\Carbon::parse($end_date)) + 1}} days)
                </p>
            </div>
        @elseif($start_date && $end_date && $total_price === null)
            <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded">
                <p class="text-sm text-red-800">
                    <strong>Selected dates are not available.</strong> Please choose different dates.
                </p>
            </div>
        @endif

        <button 
            @if(auth()->check()) 
                wire:click="rent"
            @else
                onclick="window.location.href='{{ route('login') }}'"
            @endif
            class="bg-fuchsia-600 text-white px-4 py-2 rounded hover:bg-fuchsia-700 w-full {{ ($total_price === null && $start_date && $end_date) ? 'opacity-50 cursor-not-allowed' : '' }}"
            @if($total_price === null && $start_date && $end_date) disabled @endif
        >
            {{ auth()->check() ? 'Submit Rental Request' : 'Login to Rent' }}
        </button>
    </div>

    @if(session()->has('message'))
        <div class="mt-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('message') }}
        </div>
    @endif

    <!-- JavaScript to disable unavailable dates -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const unavailableDates = @json($unavailableDates);
            
            function disableUnavailableDates() {
                const startDatePicker = document.getElementById('start-date-picker');
                const endDatePicker = document.getElementById('end-date-picker');
                
                if (startDatePicker) {
                    startDatePicker.addEventListener('input', function(e) {
                        if (unavailableDates.includes(e.target.value)) {
                            e.target.value = '';
                            alert('This date is not available. Please select another date.');
                        }
                    });
                }
                
                if (endDatePicker) {
                    endDatePicker.addEventListener('input', function(e) {
                        if (unavailableDates.includes(e.target.value)) {
                            e.target.value = '';
                            alert('This date is not available. Please select another date.');
                        }
                    });
                }
            }
            
            disableUnavailableDates();
            
            // Re-run after Livewire updates
            document.addEventListener('livewire:navigated', disableUnavailableDates);
        });
    </script>
</div>