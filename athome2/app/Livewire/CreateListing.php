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

    // PSGC data
    public $provinces = [];
    public $cities = [];
    public $barangays = [];
    public $selectedProvince = '';
    public $selectedCity = '';

    public function mount()
    {
        $this->loadProvinces();
    }

    public function loadProvinces()
    {
        try {
            $response = Http::get('https://psgc.gitlab.io/api/provinces');
            
            if ($response->successful()) {
                $this->provinces = $response->json();
            } else {
                $this->provinces = [];
                session()->flash('error', 'Failed to load provinces. Please try again.');
            }
        } catch (\Exception $e) {
            $this->provinces = [];
            session()->flash('error', 'Unable to connect to address service. Please try again.');
        }
    }

    public function updatedSelectedProvince($value)
    {
        $provinceName = collect($this->provinces)->firstWhere('code', $value)['name'] ?? '';
        $this->province = $provinceName;
        
        // Reset dependent fields
        $this->selectedCity = '';
        $this->city = '';
        $this->barangay = '';
        $this->cities = [];
        $this->barangays = [];
        
        if ($value) {
            $this->loadCities($value);
        }
    }

    public function updatedSelectedCity($value)
    {
        $cityName = collect($this->cities)->firstWhere('code', $value)['name'] ?? '';
        $this->city = $cityName;
        
        // Reset dependent fields
        $this->barangay = '';
        $this->barangays = [];
        
        if ($value) {
            $this->loadBarangays($value);
        }
    }

    public function loadCities($provinceCode)
    {
        try {
            $response = Http::get("https://psgc.gitlab.io/api/provinces/{$provinceCode}/cities-municipalities");
            
            if ($response->successful()) {
                $this->cities = $response->json();
            } else {
                $this->cities = [];
                session()->flash('error', 'Failed to load cities. Please try again.');
            }
        } catch (\Exception $e) {
            $this->cities = [];
            session()->flash('error', 'Unable to load cities. Please try again.');
        }
    }

    public function loadBarangays($cityCode)
    {
        try {
            $response = Http::get("https://psgc.gitlab.io/api/cities-municipalities/{$cityCode}/barangays");
            
            if ($response->successful()) {
                $barangayData = $response->json();
                $this->barangays = collect($barangayData)->pluck('name')->toArray();
            } else {
                $this->barangays = [];
                session()->flash('error', 'Failed to load barangays. Please try again.');
            }
        } catch (\Exception $e) {
            $this->barangays = [];
            session()->flash('error', 'Unable to load barangays. Please try again.');
        }
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