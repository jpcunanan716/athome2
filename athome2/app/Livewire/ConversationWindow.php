<?php

namespace App\Livewire;

use App\Models\Conversation;
use App\Models\Message;
use Livewire\Component;

class ConversationWindow extends Component
{
    public $conversation;
    public $messages;
    public $newMessage = '';
    public $isTyping = false;
    public $typingUser = null;

    protected $listeners = ['messageReceived', 'userTyping'];

    public function mount(Conversation $conversation)
    {
        $this->conversation = $conversation;
        $this->loadMessages();
    }

    public function loadMessages()
    {
        $this->messages = $this->conversation->messages()
            ->with('sender')
            ->latest()
            ->get();
    }

    public function sendMessage()
    {
        $this->validate(['newMessage' => 'required|string|max:2000']);
        
        $message = Message::create([
            'conversation_id' => $this->conversation->id,
            'sender_id' => auth()->id(),
            'content' => $this->newMessage
        ]);
        
        $this->messages->prepend($message);
        $this->newMessage = '';
        
        // Broadcast the new message
        broadcast(new NewMessageEvent($message))->toOthers();
        
        $this->dispatchBrowserEvent('message-sent');
    }

    public function messageReceived($messageId)
    {
        $message = Message::with('sender')->find($messageId);
        $this->messages->prepend($message);
        $this->dispatchBrowserEvent('message-received');
    }

    public function userTyping($userId)
    {
        $user = User::find($userId);
        $this->isTyping = true;
        $this->typingUser = $user;
        
        // Reset typing indicator after 3 seconds
        $this->dispatchBrowserEvent('reset-typing', ['duration' => 3000]);
    }

    public function render()
    {
        return view('livewire.conversation-window')->layout('layouts.app');
    }
}
