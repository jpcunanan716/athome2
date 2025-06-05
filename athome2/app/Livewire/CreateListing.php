<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\House;
use App\Models\Media;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;

class CreateListing extends Component
{
    // Form data properties
    public $houseName;
    public $housetype;
    public $street;
    public $region;
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
    public $electric_meter = false;
    public $water_meter = false;
    public $price;

    // Step management
    public $currentStep = 1;
    public $totalSteps = 3;

    // Address search
    public $addressQuery = '';
    public $addressResults = [];
    public $showAddressResults = false;

    public function searchAddress()
    {
        if (strlen($this->addressQuery) < 3) {
            $this->addressResults = [];
            $this->showAddressResults = false;
            return;
        }

        try {
            $response = Http::get('https://ejrayo.github.io/phil-address/autocomplete', [
                'q' => $this->addressQuery
            ]);
            
            if ($response->successful()) {
                $this->addressResults = $response->json();
                $this->showAddressResults = !empty($this->addressResults);
            } else {
                $this->addressResults = [];
                $this->showAddressResults = false;
                session()->flash('error', 'Failed to search address. Please try again.');
            }
        } catch (\Exception $e) {
            $this->addressResults = [];
            $this->showAddressResults = false;
            session()->flash('error', 'Unable to connect to address service. Please try again.');
        }
    }

    public function selectAddress($address)
    {
        try {
            $response = Http::get('https://ejrayo.github.io/phil-address/details', [
                'address' => $address
            ]);
            
            if ($response->successful()) {
                $addressData = $response->json();
                
                $this->street = $addressData['street'] ?? '';
                $this->barangay = $addressData['barangay'] ?? '';
                $this->city = $addressData['city'] ?? '';
                $this->province = $addressData['province'] ?? '';
                $this->region = $addressData['region'] ?? '';
                
                $this->addressQuery = implode(', ', array_filter([
                    $this->street,
                    $this->barangay,
                    $this->city,
                    $this->province
                ]));
                
                $this->showAddressResults = false;
            } else {
                session()->flash('error', 'Failed to get address details. Please try again.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Unable to get address details. Please try again.');
        }
    }

    public function clearAddress()
    {
        $this->addressQuery = '';
        $this->street = '';
        $this->barangay = '';
        $this->city = '';
        $this->province = '';
        $this->region = '';
        $this->addressResults = [];
        $this->showAddressResults = false;
    }

    public function nextStep()
    {
        $this->validateCurrentStep();
        
        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function goToStep($step)
    {
        if ($step >= 1 && $step <= $this->totalSteps && $step <= $this->currentStep + 1) {
            $this->currentStep = $step;
        }
    }

    private function validateCurrentStep()
    {
        switch ($this->currentStep) {
            case 1:
                $this->validate([
                    'houseName' => 'required|string|max:255',
                    'housetype' => 'required|string|max:255',
                    'total_occupants' => 'required|integer|min:1',
                    'total_rooms' => 'required|integer|min:1',
                    'total_bathrooms' => 'required|integer|min:1',
                ]);
                break;
            case 2:
                $this->validate([
                    'street' => 'required|string|max:255',
                    'province' => 'required|string|max:255',
                    'city' => 'required|string|max:255',
                    'barangay' => 'required|string|max:255',
                ]);
                break;
            case 3:
                $this->validate([
                    'description' => 'required|string|max:65535',
                    'price' => 'required|numeric|min:0',
                ]);
                break;
        }
    }

    public function save()
    {
        // Validate all steps
        $this->validate([
            'houseName' => 'required|string|max:255',
            'housetype' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'region' => 'required|string|max:255',
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
            'electric_meter' => 'boolean',
            'water_meter' => 'boolean',
            'price' => 'required|numeric|min:0',
        ]);

        // Get the authenticated user's ID
        $user_id = Auth::id();

        // Save the house
        $house = House::create([
            'houseName' => $this->houseName,
            'housetype' => $this->housetype,
            'street' => $this->street,
            'region' => $this->region,
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
            'electric_meter' => $this->electric_meter,
            'water_meter' => $this->water_meter,
            'price' => $this->price,
            'user_id' => $user_id,
        ]);

        // Store the house ID in session
        Session::put('last_created_house_id', $house->id);

        // Dispatch an event with the newly created house's ID
        $this->dispatch('houseCreated', houseId: $house->id);

        // Reset the form fields
        $this->reset();

        return redirect()->to('/add-media/' . $house->id);
    }

    public function render()
    {
        return view('livewire.create-listing')->layout('layouts.app');
    }
}