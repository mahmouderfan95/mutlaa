<?php

namespace App\Http\Resources\Admin\Trips;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TripMediaResource extends JsonResource
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
            'original_path' => $this->original_path,
            'media_path' => $this->media_path,
            'file_name' => $this->file_name,
            'status' => $this->status
        ];
    }
}
