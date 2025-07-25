<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class House extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $fillable = [
        'houseName',
        'housetype',
        'street',
        'region',
        'province',
        'city',
        'barangay',
        'total_occupants',
        'total_rooms',
        'total_bathrooms',
        'description',
        'rules',
        'has_aircon',
        'has_kitchen',
        'has_wifi',
        'has_parking',
        'has_gym',
        'has_patio',
        'has_pool',
        'is_petfriendly',
        'electric_meter',
        'water_meter',
        'price',
        'user_id',
        'status',
        'latitude',
        'longitude',
    ];

    // Casts
    protected $casts = [
        'has_aircon' => 'boolean',
        'has_kitchen' => 'boolean',
        'has_wifi' => 'boolean',
        'has_parking' => 'boolean',
        'has_gym' => 'boolean',
        'has_patio' => 'boolean',
        'has_pool' => 'boolean',
        'is_petfriendly' => 'boolean',
        'electric_meter' => 'boolean',
        'water_meter' => 'boolean',
        'status' => 'boolean',
    ];
    
    const STATUS_ENABLED = true;
    const STATUS_DISABLED = false;

    public function media(): HasMany
    {
        return $this->hasMany(Media::class);
    }

    public function renters()
    {
        return $this->belongsToMany(User::class, 'rentals')
                    ->withPivot('start_date', 'end_date', 'total_price', 'status', 'notes')
                    ->withTimestamps();
    }

    public function favorites()
    {
        return $this->belongsToMany(House::class, 'favorites');
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    public function conversations()
    {
        return $this->hasMany(Conversation::class);
    }

    // Helper methods for status (optional)
    public function isEnabled(): bool
    {
        return $this->status === self::STATUS_ENABLED;
    }

    public function enable(): void
    {
        $this->update(['status' => self::STATUS_ENABLED]);
    }

    public function disable(): void
    {
        $this->update(['status' => self::STATUS_DISABLED]);
    }
}