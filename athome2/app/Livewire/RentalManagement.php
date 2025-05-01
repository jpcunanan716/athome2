<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Rental;
use App\Models\House;
use Illuminate\Support\Facades\Auth;

class RentalManagement extends Component
{
    public $activeTab = 'rentals';
    public $rentals;
    public $properties;
    
    // Property editing variables
    public $editingProperty = null;
    public $isEditing = false;
    
    // Form fields
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

    protected $rules = [
        'houseName' => 'required|string|max:255',
        'housetype' => 'required|string|max:100',
        'street' => 'required|string|max:255',
        'province' => 'required|string|max:100',
        'city' => 'required|string|max:100',
        'barangay' => 'required|string|max:100',
        'total_occupants' => 'required|integer|min:1',
        'total_rooms' => 'required|integer|min:0',
        'total_bathrooms' => 'required|integer|min:0',
        'description' => 'required|string',
        'has_aircon' => 'boolean',
        'has_kitchen' => 'boolean',
        'has_wifi' => 'boolean',
        'has_parking' => 'boolean',
        'has_gym' => 'boolean',
        'price' => 'required|numeric|min:0'
    ];

    public function mount()
    {
        $this->loadRentals();
        $this->loadProperties();
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

    public function loadProperties()
    {
        $this->properties = House::where('user_id', Auth::id())
            ->latest()
            ->get();
    }

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetEdit();
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

    public function editProperty($houseId)
    {
        $this->isEditing = true;
        $this->editingProperty = House::findOrFail($houseId);
        
        // Fill the form fields
        $this->houseName = $this->editingProperty->houseName;
        $this->housetype = $this->editingProperty->housetype;
        $this->street = $this->editingProperty->street;
        $this->province = $this->editingProperty->province;
        $this->city = $this->editingProperty->city;
        $this->barangay = $this->editingProperty->barangay;
        $this->total_occupants = $this->editingProperty->total_occupants;
        $this->total_rooms = $this->editingProperty->total_rooms;
        $this->total_bathrooms = $this->editingProperty->total_bathrooms;
        $this->description = $this->editingProperty->description;
        $this->has_aircon = $this->editingProperty->has_aircon;
        $this->has_kitchen = $this->editingProperty->has_kitchen;
        $this->has_wifi = $this->editingProperty->has_wifi;
        $this->has_parking = $this->editingProperty->has_parking;
        $this->has_gym = $this->editingProperty->has_gym;
        $this->price = $this->editingProperty->price;
    }

    public function updateProperty()
    {
        $this->validate();

        $this->editingProperty->update([
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
            'price' => $this->price
        ]);

        $this->resetEdit();
        $this->loadProperties();
        session()->flash('message', 'Property updated successfully.');
    }

    public function toggleActive($houseId)
    {
        $property = House::findOrFail($houseId);
        $property->update([
            'isActive' => !$property->isActive
        ]);
        
        $this->loadProperties();
        $status = $property->isActive ? 'enabled' : 'disabled';
        session()->flash('message', "Property {$status} successfully.");
    }

    public function resetEdit()
    {
        $this->isEditing = false;
        $this->editingProperty = null;
        $this->reset([
            'houseName', 'housetype', 'street', 'province', 'city', 'barangay', 
            'total_occupants', 'total_rooms', 'total_bathrooms', 'description',
            'has_aircon', 'has_kitchen', 'has_wifi', 'has_parking', 'has_gym', 'price'
        ]);
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.rental-management')->layout('layouts.app');
    }
}