<!-- resources/views/livewire/rent-house.blade.php -->
<div>
    @if(auth()->check())
        <button wire:click="$set('showForm', true)" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Rent This Property
        </button>

        @if($showForm)
            <div class="mt-4 p-4 border rounded-lg">
                <div class="mb-4">
                    <label class="block text-gray-700">Start Date</label>
                    <input type="date" wire:model="start_date" wire:change="calculatePrice" class="mt-1 block w-full">
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">End Date</label>
                    <input type="date" wire:model="end_date" wire:change="calculatePrice" class="mt-1 block w-full">
                </div>

                @if($total_price)
                    <div class="mb-4">
                        <p class="text-lg font-semibold">Total: ₱{{ number_format($total_price, 2) }}</p>
                    </div>
                @endif

                <button wire:click="rent" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                    Submit Rental Request
                </button>
            </div>
        @endif
    @else
        <a href="{{ route('login') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Login to Rent
        </a>
    @endif

    @if(session()->has('message'))
        <div class="mt-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('message') }}
        </div>
    @endif
</div>