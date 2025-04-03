<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\House;

class HouseDetails extends Component
{
    public $house;

    public function mount($houseId)
    {
        $this->house = House::with('media')->findOrFail($houseId);
    }

    public function render()
    {
        return view('livewire.house-details')->layout('layouts.app');
    }
}
