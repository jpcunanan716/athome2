<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Media extends Model
{
    protected $fillable = [
        'image_path',
        'house_id',
    ];

    /**
     * Get the house associated with the image.
     */
    public function house(): BelongsTo
    {
        return $this->belongsTo(House::class);
    }
}
