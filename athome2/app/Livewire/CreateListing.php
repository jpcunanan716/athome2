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
        'provinces', 'selectedProvince',
        'cities', 'selectedCity',
        'barangays', 'selectedBarangay'
    ]);
    $this->loadingProvinces = true;

    // Set region name
    $region = collect($this->regions)->firstWhere('code', $regionCode);
    $this->region = $region['name'] ?? null;

    if (!$regionCode) {
        $this->provinces = [];
        $this->cities = [];
        $this->barangays = [];
        $this->loadingProvinces = false;
        return;
    }

    if ($regionCode === '130000000') {
        // NCR: Skip provinces, load cities/municipalities directly
        $this->provinces = [];
        $this->loadingProvinces = false;
        $this->loadCitiesForNCR();
        return;
    }

    // Other regions: Load provinces
    try {
        $response = Http::get("https://psgc.gitlab.io/api/regions/{$regionCode}/provinces");
        $this->provinces = $response->successful() ? $response->json() : [];
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
    $this->reset(['cities', 'selectedCity', 'barangays', 'selectedBarangay']);
    if (!$provinceCode) {
        $this->cities = [];
        $this->barangays = [];
        return;
    }

    $this->loadingCities = true;
    try {
        $response = Http::get("https://psgc.gitlab.io/api/provinces/{$provinceCode}/cities-municipalities");
        $this->cities = $response->successful() ? $response->json() : [];
    } catch (\Exception $e) {
        $this->cities = [];
        session()->flash('error', 'Failed to load cities. Please try again.');
    }
    $this->loadingCities = false;
}

public function updatedSelectedCity($cityCode)
{
    $this->reset(['barangays', 'selectedBarangay']);
    if (!$cityCode) {
        $this->barangays = [];
        return;
    }

    // Assign city name
    $city = collect($this->cities)->firstWhere('code', $cityCode);
    $this->city = $city['name'] ?? null;

    try {
        $response = Http::get("https://psgc.gitlab.io/api/cities-municipalities/{$cityCode}/barangays");
        $this->barangays = $response->successful() ? $response->json() : [];
    } catch (\Exception $e) {
        $this->barangays = [];
        session()->flash('error', 'Failed to load barangays. Please try again.');
    }
}

    public function updatedSelectedBarangay($value)
    {
        if (empty($value)) return;
        
        // Find and set the barangay name
        $barangay = collect($this->barangays)->firstWhere('code', $value);
        $this->barangay = $barangay['name'] ?? '';
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
                    'selectedRegion' => 'required|string',
                    'selectedProvince' =>$this->selectedRegion === '130000000' ? 'nullable' : 'required|string',
                    'selectedCity' => 'required|string',
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

        return redirect()->to('/add-images/' . $house->id);
    }

    public function render()
    {
        return view('livewire.create-listing')->layout('layouts.app');
    }
}