<?php

namespace App\Livewire;

use App\Models\Conversation;
use App\Models\House;
use Livewire\Component;

class StartConversationButton extends Component
{
    public House $house; // Strongly type the house property
    public $showForm = false;

    public function mount(House $house)
    {
        $this->house = $house;
    }

    public function startConversation()
    {
        // Redirect if not authenticated
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Use house relationship to automatically set house_id
        $conversation = $this->house->conversations()
            ->whereHas('participants', fn($q) => $q->where('user_id', auth()->id()))
            ->firstOr(function() {
                // house_id automatically set here through the relationship
                return $this->house->conversations()->create();
            });

        // Add participants if not already attached
        $conversation->participants()->syncWithoutDetaching([
            auth()->id(),
            $this->house->user_id
        ]);

        return redirect()->route('messages.show', $conversation);
    }

    public function render()
    {
        return view('livewire.start-conversation-button');
    }
}