<?php

namespace App\Http\Resources\Admin\Trips;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TripResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
          'id' => $this->id,
          'type' => $this->type,
          'title' => [
              'ar' => $this->getTranslation('title','ar'),
              'en' => $this->getTranslation('title','en'),
          ],
            'description' => [
                'ar' => $this->getTranslation('description','ar'),
                'en' => $this->getTranslation('description','en'),
            ],
            'includes' => [
                'ar' => $this->getTranslation('includes','ar'),
                'en' => $this->getTranslation('includes','en'),
            ],
            'excludes' => [
                'ar' => $this->getTranslation('excludes','ar'),
                'en' => $this->getTranslation('excludes','en'),
            ],
            'hotel_name' => [
                'ar' => $this->getTranslation('hotel_name','ar'),
                'en' => $this->getTranslation('hotel_name','en'),
            ],
            'itinerary' => $this->itinerary,
            'cover_image' => $this->imageCoverUrl,
            'departure_at' => $this->departure_at,
            'return_at' => $this->return_at,
            'duration' => [
                'days' => $this->duration_days,
                'nights' => $this->duration_nights,
            ],
            'price' => [
                'amount' => $this->price,
                'price_after_discount' => $this->price_after_discount,
                'currency' => $this->currency,
            ],
            'offer' => [
//                'is_active' => $this->has_active_offer,
                'starts_at' => $this->offer_starts_at,
                'ends_at' => $this->offer_ends_at,
//                'discount_percentage' => $this->discount_percentage,
            ],
            'seats' => [
                'total' => $this->available_seats,
                'booked' => $this->booked_seats,
            ],
            'media' => TripMediaResource::collection($this->whenLoaded('media')),
        ];
    }
}
