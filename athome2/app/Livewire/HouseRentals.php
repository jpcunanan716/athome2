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
    public $number_of_guests = 1;

    public function mount(House $house)
    {
        $this->house = $house;
        $this->start_date = now()->format('Y-m-d');
        $this->end_date = now()->addDay()->format('Y-m-d');
    }

    public function calculatePrice()
    {
        $this->total_price = null;
        
        if ($this->start_date && $this->end_date) {
            $start = Carbon::parse($this->start_date);
            $end = Carbon::parse($this->end_date);
            
            // Ensure end date is not before start date
            if ($end->lt($start)) {
                $this->end_date = $this->start_date;
                $end = $start;
            }
            
            // Calculate total days (including both dates)
            $days = $start->diffInDays($end) + 1;
            $this->total_price = $days * $this->house->price;
        }
    }

    public function rent()
    {
        if (auth()->guest()) {
            return;
        }
        
        $this->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'number_of_guests' => [
                'required',
                'integer',
                'min:1',
                'max:'.$this->house->total_occupants,
            ],
        ], [
            'number_of_guests.max' => 'The number of guests cannot exceed the maximum occupancy of '.$this->house->total_occupants,
        ]);

        Rental::create([
            'user_id' => auth()->id(),
            'house_id' => $this->house->id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'total_price' => $this->total_price,
            'number_of_guests' => $this->number_of_guests,
            'status' => 'pending'
        ]);

        session()->flash('message', 'Rental request submitted successfully!');
        $this->reset(['start_date', 'end_date', 'total_price', 'showForm', 'number_of_guests']);
    }
    
    public function updatedStartDate($value)
    {
        if ($value) {
            // If end date is before or same as new start date
            if ($this->end_date && Carbon::parse($this->end_date)->lte(Carbon::parse($value))) {
                $this->end_date = Carbon::parse($value)->addDay()->format('Y-m-d');
            }
            $this->calculatePrice();
        }
    }

    public function updatedEndDate($value)
    {
        if ($value) {
            // If start date is after end date
            if ($this->start_date && Carbon::parse($value)->lt(Carbon::parse($this->start_date))) {
                $this->start_date = Carbon::parse($value)->subDay()->format('Y-m-d');
            }
            $this->calculatePrice();
        }
    }

    public function render()
    {
        return view('livewire.house-rentals')->layout('layouts.app');
    }
}