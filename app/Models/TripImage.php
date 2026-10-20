<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TripImage extends Model
{
    protected $fillable = [
        'trip_id',
        'original_path',
        'media_path',
        'file_name',
        'file_extension',
        'is_main',
        'status',
    ];
    public function trip() : BelongsTo
    {
        return $this->belongsTo(Trip::class, 'trip_id');
    }
}
