<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Rental;
use App\Models\House;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class RentalManagement extends Component
{
    use WithFileUploads;

    public $activeTab = 'rentals';
    public $rentals;
    public $properties;
    
    // Property editing variables
    public $editingProperty = null;
    public $isEditing = false;
    public $showEditModal = false;
    
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
    public $has_patio = false;
    public $has_pool = false;
    public $is_petfriendly = false;
    public $electric_meter = false;
    public $water_meter = false;
    public $price;
    public $newImages;

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
        'has_patio' => 'boolean',
        'has_pool' => 'boolean',
        'is_petfriendly' => 'boolean',
        'electric_meter' => 'boolean',
        'water_meter' => 'boolean',
        'price' => 'required|numeric|min:0',
        'newImages.*' => 'image', // 2MB max per image
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

    public function editProperty($id)
    {
        $this->isEditing = true;
        $this->editingProperty = House::with('media')->findOrFail($id);
        
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
        $this->has_patio = $this->editingProperty->has_patio;
        $this->has_pool = $this->editingProperty->has_pool;
        $this->is_petfriendly = $this->editingProperty->is_petfriendly;
        $this->electric_meter = $this->editingProperty->electric_meter;
        $this->water_meter = $this->editingProperty->water_meter;
        $this->price = $this->editingProperty->price;
        
        // Open modal
        $this->showEditModal = true;
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
            'has_patio' => $this->has_patio,
            'has_pool' => $this->has_pool,
            'is_petfriendly' => $this->is_petfriendly,
            'electric_meter' => $this->electric_meter,
            'water_meter' => $this->water_meter,

            'price' => $this->price
        ]);

        // Handle new images
        if ($this->newImages) {
            foreach ($this->newImages as $image) {
                $path = $image->store('property-images', 'public');
                $this->editingProperty->media()->create([
                    'image_path' => $path,
                ]);
            }
        }

        // Clear selected images after update
        $this->newImages = [];

        $this->resetEdit();
        $this->loadProperties();
        session()->flash('message', 'Property updated successfully.');
    }

     public function toggleActive($id)
    {
        $property = House::findOrFail($id);
        $newStatus = $property->status ? 0 : 1; // Toggle between 1 and 0
        $property->update([
            'status' => $newStatus
        ]);
        
        $this->loadProperties();
        $status = $newStatus ? 'enabled' : 'disabled';
        session()->flash('message', "Property {$status} successfully.");
    }

    public function closeModal()
    {
        $this->showEditModal = false;
    }

    public function resetEdit()
    {
        $this->isEditing = false;
        $this->editingProperty = null;
        $this->showEditModal = false;
        $this->reset([
            'houseName', 'housetype', 'street', 'province', 'city', 'barangay', 
            'total_occupants', 'total_rooms', 'total_bathrooms', 'description',
            'has_aircon', 'has_kitchen', 'has_wifi', 'has_parking', 'has_gym',
            'has_patio', 'has_pool', 'is_petfriendly', 'electric_meter', 'water_meter', 'price'
        ]);
        $this->resetValidation();
    }

    public function deleteImage($mediaId)
    {
        $media = Media::findOrFail($mediaId);
        Storage::disk('public')->delete($media->image_path);
        $media->delete();

        // Refresh property images in modal
        if ($this->editingProperty) {
            $this->editingProperty = $this->editingProperty->fresh('media');
        }
    }

    public function render()
    {
        return view('livewire.rental-management')->layout('layouts.app');
    }
}