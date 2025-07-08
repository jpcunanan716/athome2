<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\House;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class HouseListings extends Component
{
    
    use WithPagination;

    public $search = '';
    public $type = '';
    public $guests = null; // Add this line

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingType()
    {
        $this->resetPage();
    }
    
    public function updatingGuests()
    {
        $this->resetPage();
    }

    public function toggleFavorite($houseId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        if ($user->favorites()->where('house_id', $houseId)->exists()) {
            $user->favorites()->detach($houseId);
        } else {
            $user->favorites()->attach($houseId);
        }
    }

    public function isFavorite($houseId)
    {
        if (!Auth::check()) return false;
        
        return Auth::user()->favorites()
            ->where('house_id', $houseId)
            ->exists();
    }

    public function searchHouses()
    {
        // This method is intentionally left blank.
        // It just triggers Livewire to re-render with the current filter values.
    }

    public function render()
    {
        $query = \App\Models\House::with('media')
            ->where('user_id', '!=', auth()->id());

        if ($this->search) {
            $query->where(function($q) {
                $q->where('city', 'like', '%'.$this->search.'%')
                  ->orWhere('barangay', 'like', '%'.$this->search.'%')
                  ->orWhere('province', 'like', '%'.$this->search.'%')
                  ->orWhere('houseName', 'like', '%'.$this->search.'%');
            });
        }

        if ($this->type) {
            $query->where('housetype', 'like', '%'.$this->type.'%');
        }

        if ($this->guests) { // Add this block
            $query->where('total_occupants', '>=', $this->guests);
        }

        $houses = $query->paginate(12);

        return view('livewire.house-listings', [
            'houses' => $houses,
        ])->layout('layouts.app');
    }
}