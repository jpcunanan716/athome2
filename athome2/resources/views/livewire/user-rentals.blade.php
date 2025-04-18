<div>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">My Rentals</h1>

        

        @if($rentals->isEmpty())
            <p class="text-gray-600">You haven't made any rentals yet.</p>
        @else
            <div class="grid gap-4">
                @foreach($rentals as $rental)
                    <div class="bg-white p-4 rounded-lg shadow-md">
                        <div class="flex justify-between items-start">
                            <div>
                                <h2 class="text-xl font-semibold">{{ $rental->house->houseName }}</h2>
                                <p class="text-gray-600">{{ $rental->house->street }}, {{ $rental->house->city }}</p>
                            </div>
                            <span class="px-3 py-1 text-sm rounded-full 
                                {{ $rental->status === 'approved' ? 'bg-green-200 text-green-800' : 
                                   ($rental->status === 'rejected' ? 'bg-red-200 text-red-800' : 'bg-yellow-200 text-yellow-800') }}">
                                {{ ucfirst($rental->status) }}
                            </span>
                        </div>

                        <div class="mt-4 grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Dates:</p>
                                <p>{{ $rental->start_date->format('M d, Y') }} - {{ $rental->end_date->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Duration:</p>
                                <p>{{ $rental->duration }} days</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Total Price:</p>
                                <p>₱{{ number_format($rental->total_price, 2) }}</p>
                            </div>
                        </div>

                        @if($rental->notes)
                            <div class="mt-4">
                                <p class="text-sm text-gray-600">Owner's Notes:</p>
                                <p class="italic">{{ $rental->notes }}</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>