<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\House;
use App\Models\User;
use App\Models\Conversation;

class NewConversation extends Component
{
    public $showModal = false;
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

    public function mount()
    {
        $this->listeners = [
            'open-new-conversation-modal' => 'openModal'
        ];
    }

    public function openModal($houseId = null)
{
    $this->reset();
    $this->houseId = $houseId;
    
    if ($houseId) {
        $house = House::findOrFail($houseId);
        // Auto-add house owner to recipients
        if ($house->owner_id) {
            $this->selectedUsers[] = $house->owner_id;
        }
        
        // For existing rentals, add all tenants
        if (auth()->user()->id === $house->owner_id) {
            $tenantIds = $house->rentals->pluck('user_id')->toArray();
            $this->selectedUsers = array_merge($this->selectedUsers, $tenantIds);
        }
    }
    
    $this->showModal = true;
}
    
    public function closeModal()
    {
        $this->showModal = false;
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
        
        $this->closeModal();
        
        // Emit event to refresh conversations list
        $this->emitTo('conversations-list', 'conversationAdded');
        
        // Redirect to the conversation
        return redirect()->route('conversations.show', $conversation);
    }
    
    public function render()
    {
        $houses = auth()->user()->houses;
        $users = User::all();
        
        return view('livewire.new-conversation', [
            'houses' => $houses,
            'users' => $users
        ]);
    }
}