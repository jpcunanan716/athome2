<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Rental;
use Illuminate\Support\Facades\Auth;

class UserRentals extends Component
{
    public $rentals;

    public function mount()
    {
        $this->loadRentals();
    }

    public function loadRentals()
    {
        $this->rentals = Rental::with(['house'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
    }

    public function render()
    {
        return view('livewire.user-rentals')->layout('layouts.app');
    }
}