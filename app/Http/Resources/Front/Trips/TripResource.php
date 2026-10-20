<?php

namespace App\Http\Resources\Front\Trips;

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
          'title' => $this->title,
          'departure_at' => $this->departure_at,
          'duration_nights' => $this->duration_nights,
          'price' => $this->price,
          'price_after_discount' => $this->price_after_discount,
          'available_seats' => $this->available_seats,
          'booked_seats' => $this->booked_seats,
          'cover_image' => $this->imageCoverUrl
        ];
    }
}
