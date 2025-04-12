<?php

namespace App\Livewire;

use Livewire\Component;

class ConversationList extends Component
{
    public $conversations;

    public function mount()
    {
        $this->loadConversations();
    }

    public function loadConversations()
    {
        $this->conversations = auth()->user()->conversations()
            ->with(['otherParticipant', 'property', 'messages' => function($q) {
                $q->latest()->limit(1);
            }])
            ->get()
            ->sortByDesc(function($conversation) {
                return $conversation->messages->first()->created_at ?? $conversation->created_at;
            });
    }

    public function render()
    {
        return view('livewire.conversation-list')->layout('layouts.app');
    }
}
