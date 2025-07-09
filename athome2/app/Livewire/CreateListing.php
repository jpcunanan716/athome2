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
    public $total_occupants = 1;
    public $total_rooms = 1;
    public $total_bathrooms = 1;
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
    public $latitude;
    public $longitude;

    // Step management
    public $currentStep = 1;
    public $totalSteps = 6;

    // Address selection
    public $selectedRegion;
    public $selectedProvince;
    public $selectedCity;
    public $selectedBarangay;
    
    // Address data
    public $regions = [];
    public $provinces = [];
    public $cities = [];
    public $barangays = [];
    public $loadingProvinces = false;
    public $loadingCities = false;
    public $loadingBarangays = false;

    protected $messages = [
        'houseName.required' => 'The property name is required.',
        'housetype.required' => 'Please select a property type.',
        'street.required' => 'Street address is required.',
        'region.required' => 'Please select a region.',
        'province.required' => 'Please select a province.',
        'city.required' => 'Please select a city.',
        'barangay.required' => 'Please select a barangay.',
        'total_occupants.required' => 'Enter the maximum number of occupants.',
        'total_rooms.required' => 'Enter the number of rooms.',
        'total_bathrooms.required' => 'Enter the number of bathrooms.',
        'description.required' => 'Please provide a description.',
        'price.required' => 'Please enter a price.',
    ];

    public function mount()
    {
        $this->loadRegions();
    }

    public function loadRegions()
    {
        try {
            $response = Http::get('https://psgc.gitlab.io/api/regions/');
            $this->regions = $response->successful() ? $response->json() : [];
        } catch (\Exception $e) {
            $this->regions = [];
            session()->flash('error', 'Failed to load regions. Please try again.');
        }
    }

    public function updatedSelectedRegion($regionCode)
    {
        // Reset dependent fields
        $this->reset([
            'provinces', 'selectedProvince', 'province',
            'cities', 'selectedCity', 'city',
            'barangays', 'selectedBarangay', 'barangay'
        ]);

        if (!$regionCode) {
            return;
        }

        // Set region name
        $region = collect($this->regions)->firstWhere('code', $regionCode);
        $this->region = $region['name'] ?? null;

        // Handle NCR (National Capital Region) - code 130000000
        if ($regionCode === '130000000') {
            $this->province = 'Metro Manila'; // Auto-set province for NCR
            $this->provinces = []; // NCR doesn't have provinces in the traditional sense
            $this->loadCitiesForNCR();
            return;
        }

        // Load provinces for other regions
        $this->loadingProvinces = true;
        try {
            $response = Http::get("https://psgc.gitlab.io/api/regions/{$regionCode}/provinces");
            $this->provinces = $response->successful() ? $response->json() : [];
            
            // Auto-select province if there's only one
            if (count($this->provinces) === 1) {
                $this->selectedProvince = $this->provinces[0]['code'];
                $this->province = $this->provinces[0]['name'];
                $this->loadCitiesForProvince($this->selectedProvince);
            }
        } catch (\Exception $e) {
            $this->provinces = [];
            session()->flash('error', 'Failed to load provinces. Please try again.');
        }
        $this->loadingProvinces = false;
    }

    public function loadCitiesForNCR()
    {
        $this->loadingCities = true;
        try {
            $response = Http::get("https://psgc.gitlab.io/api/regions/130000000/cities-municipalities");
            $this->cities = $response->successful() ? $response->json() : [];
        } catch (\Exception $e) {
            $this->cities = [];
            session()->flash('error', 'Failed to load NCR cities. Please try again.');
        }
        $this->loadingCities = false;
    }

    public function updatedSelectedProvince($provinceCode)
    {
        // Reset dependent fields
        $this->reset(['cities', 'selectedCity', 'city', 'barangays', 'selectedBarangay', 'barangay']);

        if (!$provinceCode) {
            return;
        }

        // Set province name
        $province = collect($this->provinces)->firstWhere('code', $provinceCode);
        $this->province = $province['name'] ?? null;

        $this->loadCitiesForProvince($provinceCode);
    }

    public function loadCitiesForProvince($provinceCode)
    {
        $this->loadingCities = true;
        try {
            $response = Http::get("https://psgc.gitlab.io/api/provinces/{$provinceCode}/cities-municipalities");
            $this->cities = $response->successful() ? $response->json() : [];
            
            // Auto-select city if there's only one
            if (count($this->cities) === 1) {
                $this->selectedCity = $this->cities[0]['code'];
                $this->city = $this->cities[0]['name'];
                $this->loadBarangaysForCity($this->selectedCity);
            }
        } catch (\Exception $e) {
            $this->cities = [];
            session()->flash('error', 'Failed to load cities. Please try again.');
        }
        $this->loadingCities = false;
    }

    public function updatedSelectedCity($cityCode)
    {
        // Reset dependent fields
        $this->reset(['barangays', 'selectedBarangay', 'barangay']);

        if (!$cityCode) {
            return;
        }

        // Set city name
        $city = collect($this->cities)->firstWhere('code', $cityCode);
        $this->city = $city['name'] ?? null;

        $this->loadBarangaysForCity($cityCode);
    }

    public function loadBarangaysForCity($cityCode)
    {
        $this->loadingBarangays = true;
        try {
            $response = Http::get("https://psgc.gitlab.io/api/cities-municipalities/{$cityCode}/barangays");
            $this->barangays = $response->successful() ? $response->json() : [];
        } catch (\Exception $e) {
            $this->barangays = [];
            session()->flash('error', 'Failed to load barangays. Please try again.');
        }
        $this->loadingBarangays = false;
    }

    public function updatedSelectedBarangay($barangayCode)
    {
        if (empty($barangayCode)) {
            $this->barangay = null;
            return;
        }

        // Set barangay name
        $barangay = collect($this->barangays)->firstWhere('code', $barangayCode);
        $this->barangay = $barangay['name'] ?? null;
    }

    private function geocodeAddress()
    {
        if (empty($this->street) || empty($this->city) || empty($this->province)) {
            return;
        }
        
        $address = $this->street . ', ' . $this->city . ', ' . $this->province . ', Philippines';
        
        try {
            // Using a simple geocoding service (you can replace with your preferred service)
            $response = Http::get('https://nominatim.openstreetmap.org/search', [
                'q' => $address,
                'format' => 'json',
                'limit' => 1
            ]);
            
            if ($response->successful()) {
                $data = $response->json();
                if (!empty($data)) {
                    $this->latitude = (float) $data[0]['lat'];
                    $this->longitude = (float) $data[0]['lon'];
                }
            }
        } catch (\Exception $e) {
            // Fallback to Manila coordinates
            $this->latitude = 14.5995;
            $this->longitude = 120.9842;
        }
    }

    public function nextStep()
    {
        $this->validateCurrentStep();
        
        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
            
            // Geocode address when moving to map step
            if ($this->currentStep == 4 && empty($this->latitude)) {
                $this->geocodeAddress();
            }
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
            case 1: // Step 1: House Name & Type
                $this->validate([
                    'houseName' => 'required|string|max:255',
                    'housetype' => 'required|string|max:255',
                ]);
                break;
            case 2: // Step 2: Capacity
                $this->validate([
                    'total_occupants' => 'required|integer|min:1',
                    'total_rooms' => 'required|integer|min:1',
                    'total_bathrooms' => 'required|integer|min:1',
                ]);
                break;
            case 3: // Step 3: Address
                $this->validate([
                    'street' => 'required|string|max:255',
                    'selectedRegion' => 'required|string',
                    'selectedProvince' => $this->selectedRegion === '130000000' ? 'nullable' : 'required|string',
                    'selectedCity' => 'required|string',
                    'selectedBarangay' => 'required|string',
                ]);
                break;
            case 4: // Step 4: Pin Location
                $this->validate([
                    'latitude' => 'required|numeric|between:-90,90',
                    'longitude' => 'required|numeric|between:-180,180',
                ]);
                break;
            case 5: // Step 4: Amenities
                $this->validate([
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
                ]);
                break;
            case 6: // Step 5: Description & Price
                $this->validate([
                    'description' => 'required|string|max:65535',
                    'price' => 'required|numeric|min:0',
                ]);
                break;
        }
    }

    public function increment($field)
    {
        $this->$field = ($this->$field ?? 1) + 1;
    }

    public function decrement($field)
    {
        $this->$field = ($this->$field > 1) ? $this->$field - 1 : 1;
    }

    public function save()
    {
        // Validate all steps
        $this->validate([
            'houseName' => 'required|string|max:255',
            'housetype' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'region' => 'required|string|max:255',
            'province' => $this->selectedRegion === '130000000' ? 'nullable' : 'required|string',
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
            'has_patio' => 'boolean',
            'has_pool' => 'boolean',
            'is_petfriendly' => 'boolean',
            'electric_meter' => 'boolean',
            'water_meter' => 'boolean',
            'price' => 'required|numeric|min:0',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
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
            'has_patio' => $this->has_patio,
            'has_pool' => $this->has_pool,
            'is_petfriendly' => $this->is_petfriendly,
            'electric_meter' => $this->electric_meter,
            'water_meter' => $this->water_meter,
            'price' => $this->price,
            'user_id' => $user_id,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ]);

        // Store the house ID in session
        Session::put('last_created_house_id', $house->id);

        // Dispatch an event with the newly created house's ID
        $this->dispatch('houseCreated', houseId: $house->id);

        return redirect()->to('/add-images/' . $house->id);
    }

    public function render()
    {
        return view('livewire.create-listing')->layout('layouts.app');
    }
}