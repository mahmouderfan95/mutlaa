<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
      'trip_id',
      'type',
      'number_of_pilgrims',
      'departure_at',
      'name',
      'phone',
      'email',
      'nationality',
      'notes',
      'payment_type'
    ];
    public function trip() : BelongsTo
    {
        return $this->belongsTo(Trip::class, 'trip_id');
    }
}
