<div>
    <div class="mt-4 p-4 border rounded-lg">
        <div class="mb-4">
            <label class="block text-gray-700">Start Date</label>
            <input 
                type="date" 
                wire:model="start_date" 
                wire:change="calculatePrice" 
                class="mt-1 block w-full"
                min="{{ now()->format('Y-m-d') }}"
                value="{{ $start_date ?? now()->format('Y-m-d') }}"
            >
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">End Date</label>
            <input 
                type="date" 
                wire:model="end_date" 
                wire:change="calculatePrice" 
                class="mt-1 block w-full"
                min="{{ $start_date ?? now()->format('Y-m-d') }}"
                value="{{ $end_date ?? now()->addDay()->format('Y-m-d') }}"
            >
        </div>

        @if($total_price)
            <div class="mb-4">
                <p class="text-lg font-semibold">Total: ₱{{ number_format($total_price, 2) }}</p>
            </div>
        @endif

        <button 
            @if(auth()->check()) 
                wire:click="rent"
            @else
                onclick="window.location.href='{{ route('login') }}'"
            @endif
            class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 w-full"
        >
            {{ auth()->check() ? 'Submit Rental Request' : 'Login to Rent' }}
        </button>
    </div>

    @if(session()->has('message'))
        <div class="mt-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('message') }}
        </div>
    @endif
</div>