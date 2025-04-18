<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\House;
use App\Models\User;
use App\Models\Conversation;

class CreateConversation extends Component
{
    public $houseId;
    public $subject;
    public $selectedUsers = [];
    public $message;
    
    protected $rules = [
        'houseId' => 'required|exists:houses,id',
        'subject' => 'required|string|max:255',
        'selectedUsers' => 'required|array|min:1',
        'selectedUsers.*' => 'exists:users,id',
        'message' => 'required|string'
    ];

    // Capture house_id from URL if provided
    public function mount($house_id = null)
    {
        $this->houseId = $house_id;
        
        // Pre-populate recipients if house_id is provided
        if ($this->houseId) {
            $house = House::find($this->houseId);
            if ($house) {
                // If current user is house owner, add all tenants
                if (auth()->id() === $house->user_id) {
                    $tenantIds = $house->rentals->pluck('user_id')->toArray();
                    $this->selectedUsers = array_values(array_diff($tenantIds, [auth()->id()]));
                } 
                // If current user is tenant, add the owner
                else {
                    $this->selectedUsers = [$house->user_id];
                }
            }
        }
    }
    
    public function startConversation()
    {
        $this->validate();
        
        // Create new conversation
        $conversation = Conversation::create([
            'house_id' => $this->houseId,
            'subject' => $this->subject
        ]);
        
        // Add participants including the sender
        $participants = collect($this->selectedUsers)->push(auth()->id())->unique();
        $conversation->users()->attach($participants);
        
        // Create first message
        $conversation->messages()->create([
            'user_id' => auth()->id(),
            'content' => $this->message
        ]);
        
        // Redirect to the conversation
        return redirect()->route('conversations.show', $conversation);
    }
    
    public function render()
    {
        $houses = House::all(); // Or filter based on user permissions
        $users = User::where('id', '!=', auth()->id())->get();
        
        return view('livewire.create-conversation', [
            'houses' => $houses,
            'users' => $users
        ])->layout('layouts.app');
    }
}
