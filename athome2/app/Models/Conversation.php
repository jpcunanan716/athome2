<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Conversation extends Model
{
    use HasFactory;
    
    protected $fillable = ['house_id', 'subject'];
    
    public function house()
    {
        return $this->belongsTo(House::class);
    }
    
    public function users()
    {
        return $this->belongsToMany(User::class)
                    ->withPivot('last_read_at')
                    ->withTimestamps();
    }
    
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    
    public function latestMessage()
    {
        return $this->hasOne(Message::class)->latest();
    }
    
    public function unreadMessagesForUser($userId)
    {
        $pivotData = $this->users()->where('user_id', $userId)->first()?->pivot;
        $lastReadAt = $pivotData ? $pivotData->last_read_at : null;
        
        $query = $this->messages()->where('user_id', '!=', $userId);
        
        if ($lastReadAt) {
            $query->where('created_at', '>', $lastReadAt);
        }
        
        return $query->count();
    }
}