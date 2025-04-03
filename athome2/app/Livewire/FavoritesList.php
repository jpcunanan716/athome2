<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class FavoritesList extends Component
{
    public function render()
{
    $favorites = auth()->check() 
        ? auth()->user()->favorites()
              ->with('media')
              ->paginate(12)
        : collect();

    return view('livewire.favorites-list', compact('favorites'))->layout('layouts.app');
}

    public function toggleFavorite($houseId)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        auth()->user()->favorites()->toggle($houseId);
        
        // Refresh the favorites list after toggling
        $this->favorites = auth()->user()->favorites()
                                ->with('media')
                                ->paginate(12);
    }
}
