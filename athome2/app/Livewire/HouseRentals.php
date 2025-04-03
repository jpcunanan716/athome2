<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\House;
use App\Models\Rental;
use Carbon\Carbon;

class HouseRentals extends Component
{
    public $house;
    public $start_date;
    public $end_date;
    public $total_price;
    public $showForm = false;

    public function mount(House $house)
    {
        $this->house = $house;
    }

    public function calculatePrice()
    {
        if ($this->start_date && $this->end_date) {
            $start = Carbon::parse($this->start_date);
            $end = Carbon::parse($this->end_date);
            $days = $end->diffInDays($start);
            $this->total_price = $days * $this->house->price;
        }
    }

    public function rent()
    {
        $this->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        Rental::create([
            'user_id' => auth()->id(),
            'house_id' => $this->house->id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'total_price' => $this->total_price,
            'status' => 'pending'
        ]);

        session()->flash('message', 'Rental request submitted successfully!');
        $this->reset(['start_date', 'end_date', 'total_price', 'showForm']);
    }
    
    public function render()
    {
        return view('livewire.house-rentals')->layout('layouts.app');
    }
}
