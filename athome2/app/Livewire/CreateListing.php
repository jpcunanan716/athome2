<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\House;
use App\Models\Media;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CreateListing extends Component
{
    public $houseName;
    public $housetype;
    public $street;
    public $province;
    public $city;
    public $barangay;
    public $total_occupants;
    public $total_rooms;
    public $total_bathrooms;
    public $description;
    public $has_aircon = false;
    public $has_kitchen = false;
    public $has_wifi = false;
    public $has_parking = false;
    public $has_gym = false;
    public $price;


   public function save()
    {
        // Validate the input
        $this->validate([
            'houseName' => 'required|string|max:255',
            'housetype' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
            'total_occupants' => 'required|integer|min:1',
            'total_rooms' => 'required|integer|min:1',
            'total_bathrooms' => 'required|integer|min:1',
            'description' => 'required|string|max:65535',
            'has_aircon' => 'boolean',
            'has_kitchen' => 'boolean',
            'has_wifi' => 'boolean',
            'has_parking' => 'boolean',
            'has_gym' => 'boolean',
            'price' => 'required|numeric|min:0',
        ]);

        
        // Get the authenticated user's ID
        $user_id = Auth::id();

        // Save the house
        $house  = House::create([
                'houseName' => $this->houseName,
                'housetype' => $this->housetype,
                'street' => $this->street,
                'province' => $this->province,
                'city' => $this->city,
                'barangay' => $this->barangay,
                'total_occupants' => $this->total_occupants,
                'total_rooms' => $this->total_rooms,
                'total_bathrooms' => $this->total_bathrooms,
                'description' => $this->description,
                'has_aircon' => $this->has_aircon,
                'has_kitchen' => $this->has_kitchen,
                'has_wifi' => $this->has_wifi,
                'has_parking' => $this->has_parking,
                'has_gym' => $this->has_gym,
                'price' => $this->price,
                'user_id' => $user_id,
        ]);

        
        // Store the house ID in session
        Session::put('last_created_house_id', $house->id);

        // Dispatch an event with the newly created house's ID
        $this->dispatch('houseCreated', houseId: $house->id);

        // Reset the form fields
        $this->reset();

        return redirect()->to('/add-images');
    }
    
    public function render()
    {
        return view('livewire.create-listing')->layout('layouts.app');
    }
}
