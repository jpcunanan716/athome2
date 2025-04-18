<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Conversation;
use Livewire\WithPagination;


class ConversationsList extends Component
{
    use WithPagination;
    
    protected $listeners = ['conversationAdded' => '$refresh'];
    
    public function render()
    {
        $conversations = auth()->user()->conversations()
                        ->with(['latestMessage', 'house', 'users'])
                        ->latest('updated_at')
                        ->paginate(10);
                        
        return view('livewire.conversations-list', [
            'conversations' => $conversations
        ]);
    }
    
    public function markAsRead($conversationId)
    {
        $conversation = Conversation::findOrFail($conversationId);
        
        // Update last read timestamp
        $conversation->users()->updateExistingPivot(auth()->id(), [
            'last_read_at' => now()
        ]);
        
        $this->emitTo('conversation-messages', 'refreshMessages', $conversationId);
    }
}