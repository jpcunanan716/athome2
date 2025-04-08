<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Rental;
use Illuminate\Support\Facades\Auth;

class RentalManagement extends Component
{
    public $rentals;

    public function mount()
    {
        $this->loadRentals();
    }

    public function loadRentals()
    {
        $this->rentals = Rental::with(['user', 'house'])
            ->whereHas('house', function($query) {
                // Only show rentals for properties owned by current user
                $query->where('user_id', Auth::id());
            })
            ->latest()
            ->get();
    }

    public function approve($rentalId)
    {
        $rental = Rental::findOrFail($rentalId);
        $rental->update(['status' => 'approved']);
        $this->loadRentals(); // Refresh the list
    }

    public function reject($rentalId)
    {
        $rental = Rental::findOrFail($rentalId);
        $rental->update(['status' => 'rejected']);
        $this->loadRentals(); // Refresh the list
    }

    public function render()
    {
        return view('livewire.rental-management')->layout('layouts.app');
    }
}