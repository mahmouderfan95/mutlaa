<?php

namespace App\Http\Resources\Admin\Orders;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'number_of_pilgrims' => $this->number_of_pilgrims,
            'departure_at' => $this->departure_at,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'nationality' => $this->nationality,
            'payment_type' => $this->payment_type,
            'tripe' => [
                'id' => $this->trip?->id,
                'title' => [
                    'ar' => $this->trip?->getTranslation('title','ar'),
                    'en' => $this->trip?->getTranslation('title','en'),
                ],
            ]
        ];
    }
}
