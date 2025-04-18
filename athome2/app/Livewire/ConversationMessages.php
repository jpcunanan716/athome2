<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Conversation;
use App\Models\Message;
use Livewire\WithPagination;

class ConversationMessages extends Component
{
    use WithPagination;
    
    public $conversationId;
    public $messageText = '';
    
    protected $rules = [
        'messageText' => 'required|string'
    ];
    
    // In Livewire v3, listeners are defined differently
    protected function getListeners()
    {
        return [
            'refresh-messages' => 'refreshMessages',
            'message-added' => '$refresh'
        ];
    }
    
    public function mount($conversationId)
    {
        $this->conversationId = $conversationId;
    }
    
    public function refreshMessages($conversationId = null)
    {
        if (!$conversationId || $this->conversationId == $conversationId) {
            $this->resetPage();
        }
    }
    
    public function sendMessage()
    {
        $this->validate();
        
        $conversation = Conversation::findOrFail($this->conversationId);
        
        // Create message
        $message = $conversation->messages()->create([
            'user_id' => auth()->id(),
            'content' => $this->messageText
        ]);
        
        // Update conversation timestamp
        $conversation->touch();
        
        // Reset form
        $this->reset('messageText');
        
        // In Livewire v3, use $this->dispatch() instead of emit methods
        $this->dispatch('message-added');
        $this->dispatch('conversation-added')->to('ConversationsList');
    }
    
    public function render()
    {
        $conversation = Conversation::with('house', 'users')->findOrFail($this->conversationId);
        
        // Update last read timestamp
        $conversation->users()->updateExistingPivot(auth()->id(), [
            'last_read_at' => now()
        ]);
        
        $messages = $conversation->messages()
                    ->with('user')
                    ->orderBy('created_at', 'asc')
                    ->paginate(15);
                    
        return view('livewire.conversation-messages', [
            'conversation' => $conversation,
            'messages' => $messages
        ])->layout('layouts.app');
    }
}