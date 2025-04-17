<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = ['house_id'];

    public function property()
    {
        return $this->belongsTo(House::class);
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'message_participants')
                    ->withPivot(['is_read', 'last_read_at'])
                    ->withTimestamps();
    }

    public function getOtherParticipantAttribute()
    {
        return $this->participants()
                    ->where('users.id', '!=', auth()->id())
                    ->first();
    }


    public function messages()
    {
        return $this->hasMany(Message::class)->latest();
    }

    public function otherParticipant()
    {
        return $this->belongsToMany(User::class, 'message_participants')
                    ->where('users.id', '!=', auth()->id())
                    ->withPivot(['is_read', 'last_read_at'])
                    ->limit(1); // Still returns a relation instance
    }

    public function unreadCount()
    {
        return $this->messages()
            ->where('sender_id', '!=', auth()->id())
            ->whereNull('read_at')
            ->count();
    }

    public function markAsRead()
    {
        $this->messages()
            ->where('sender_id', '!=', auth()->id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }

    public function house()
    {
        return $this->belongsTo(House::class);
    }
    
}