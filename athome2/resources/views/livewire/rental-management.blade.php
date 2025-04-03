<!-- resources/views/livewire/rental-management.blade.php -->
<div>
    <h2 class="text-2xl font-bold mb-4">Rental Requests</h2>
    
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead>
                <tr class="bg-gray-50">
                    <th class="py-3 px-4 border-b text-left">User</th>
                    <th class="py-3 px-4 border-b text-left">Property</th>
                    <th class="py-3 px-4 border-b text-left">Dates</th>
                    <th class="py-3 px-4 border-b text-left">Amount</th>
                    <th class="py-3 px-4 border-b text-left">Status</th>
                    <th class="py-3 px-4 border-b text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rentals as $rental)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-4 border-b">{{ $rental->user->name ?? 'N/A' }}</td>
                        <td class="py-3 px-4 border-b">{{ $rental->house->houseName ?? 'N/A' }}</td>
                        <td class="py-3 px-4 border-b">
                            @if($rental->start_date && $rental->end_date)
                                {{ \Carbon\Carbon::parse($rental->start_date)->format('M d, Y') }} - 
                                {{ \Carbon\Carbon::parse($rental->end_date)->format('M d, Y') }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="py-3 px-4 border-b">₱{{ number_format($rental->total_price ?? 0, 2) }}</td>
                        <td class="py-3 px-4 border-b">
                            <span class="px-2 py-1 rounded text-xs font-medium
                                @if($rental->status == 'approved') bg-green-100 text-green-800
                                @elseif($rental->status == 'rejected') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ ucfirst($rental->status ?? 'pending') }}
                            </span>
                        </td>
                        <td class="py-3 px-4 border-b">
                            @if($rental->status == 'pending')
                                <button wire:click="approve({{ $rental->id }})" 
                                        class="text-green-600 hover:text-green-800 mr-2"
                                        wire:loading.attr="disabled">
                                    Approve
                                </button>
                                <button wire:click="reject({{ $rental->id }})" 
                                        class="text-red-600 hover:text-red-800"
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
</div>