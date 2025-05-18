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

    public function render()
    {
        $houses = House::with(['media', 'favoritedBy'])
                    ->where('status', 1) // Only show enabled houses (status = 1)
                    ->withCount('favoritedBy')
                    ->paginate(12);
                    
        return view('livewire.house-listings', compact('houses'))->layout('layouts.app');
    }
}