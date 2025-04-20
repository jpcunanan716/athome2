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
    
    protected function rules()
    {
        return [
            'houseId' => 'required|exists:houses,id',
            'subject' => 'required|string|max:255',
            'selectedUsers' => 'required|array|min:1',
            'selectedUsers.*' => 'exists:users,id',
            'message' => 'required|string'
        ];
    }

    public function mount($house_id = null)
    {
        // Set house ID from route parameter
        $this->houseId = $house_id;
        
        // If no house_id is provided but user is viewing a specific house elsewhere
        if (!$this->houseId && session()->has('current_house_id')) {
            $this->houseId = session()->get('current_house_id');
        }
        
        // Auto-populate selectedUsers with all users except auth user
        $this->selectedUsers = User::where('id', '!=', auth()->id())->pluck('id')->toArray();
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
        
        // Get the current house for display if needed
        $currentHouse = $this->houseId ? House::find($this->houseId) : null;
        
        return view('livewire.create-conversation', [
            'houses' => $houses,
            'users' => $users,
            'currentHouse' => $currentHouse
        ])->layout('layouts.app');
    }
}