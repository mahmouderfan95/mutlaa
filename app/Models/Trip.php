<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Spatie\Translatable\HasTranslations;

class Trip extends Model
{
    use HasTranslations;
    protected static function booted(): void
    {
        static::deleting(function (Trip $trip) {
            $trip->media->each(function ($media) {
                Storage::disk('public')->delete($media->original_path);
                $media->delete();
            });
        });

        static::deleted(function (Trip $trip) {
            if ($trip->cover_image) {
                Storage::disk('public')->delete('trips/' . $trip->cover_image);
            }
        });
    }
    public $translatable = [
        'title',
        'description',
        'itinerary',
        'includes',
        'excludes',
        'hotel_name'
    ];
    protected $fillable = [
        'type',
        'title',
        'description',
        'itinerary',
        'includes',
        'excludes',
        'hotel_name',
        'cover_image',
        'departure_at',
        'return_at',
        'duration_days',
        'duration_nights',
        'price',
        'price_after_discount',
        'offer_starts_at',
        'offer_ends_at',
        'currency',
        'available_seats',
        'booked_seats',
        'hotel_stars',
        'status',
    ];
    public function media() :HasMany
    {
        return $this->hasMany(TripImage::class, 'trip_id');
    }
    public function getImageCoverUrlAttribute()
    {
        return $this->cover_image == null ? null : asset('storage/trips/' . $this->cover_image) ;
    }
    public function getHasActiveOfferAttribute(): bool
    {
        if ($this->price_after_discount === null) {
            return false;
        }

        if ((float) $this->price_after_discount >= (float) $this->price) {
            return false;
        }

        $now = now();

        if (
            $this->offer_starts_at !== null
            && $now->lt($this->offer_starts_at)
        ) {
            return false;
        }

        if (
            $this->offer_ends_at !== null
            && $now->gte($this->offer_ends_at)
        ) {
            return false;
        }

        return true;
    }

    public function getCurrentPriceAttribute(): string
    {
        return $this->has_active_offer
            ? $this->price_after_discount
            : $this->price;
    }

    public function getDiscountPercentageAttribute(): int
    {
        if (! $this->has_active_offer || (float) $this->price <= 0) {
            return 0;
        }

        return (int) round(
            ((float) $this->price - (float) $this->price_after_discount)
            / (float) $this->price * 100
        );
    }
}
