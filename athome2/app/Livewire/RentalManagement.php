<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Rental;

class RentalManagement extends Component
{
    public $rentals;
    public $selectedRental;

    public function mount()
    {
        $this->rentals = Rental::with(['user', 'house'])->latest()->get();
    }

    public function approve($rentalId)
    {
        $rental = Rental::find($rentalId);
        $rental->update(['status' => 'approved']);
    }

    public function reject($rentalId)
    {
        $rental = Rental::find($rentalId);
        $rental->update(['status' => 'rejected']);
    }

    public function render()
    {
        return view('livewire.rental-management')->layout('layouts.app');
    }
}
