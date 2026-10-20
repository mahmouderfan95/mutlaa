<?php

namespace App\Http\Requests\Admin\Trips;

use App\Enums\TripTypeEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => [
                'sometimes',
                'string',
                Rule::in([
                    TripTypeEnum::UMRAH,
                    TripTypeEnum::HAJJ,
                    TripTypeEnum::EVENTS,
                    TripTypeEnum::OUTBOUND,
                    TripTypeEnum::HONEYMOON,
                ]),
            ],
            'title' => ['sometimes', 'array'],
            'title.ar' => ['sometimes', 'string', 'max:255'],
            'title.en' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'array'],
            'description.ar' => ['nullable', 'string'],
            'description.en' => ['nullable', 'string'],

            'includes' => ['sometimes', 'array'],
            'includes.ar' => ['sometimes', 'string', 'max:255'],
            'includes.en' => ['nullable', 'string', 'max:255'],
            'excludes' => ['sometimes', 'array'],
            'excludes.ar' => ['sometimes', 'string', 'max:255'],
            'excludes.en' => ['nullable', 'string', 'max:255'],
            'hotel_name' => ['sometimes', 'array'],
            'hotel_name.ar' => ['sometimes', 'string', 'max:255'],
            'hotel_name.en' => ['nullable', 'string', 'max:255'],
            'itinerary' => ['nullable', 'array', 'max:60'],
            'itinerary.*.day' => ['sometimes', 'integer', 'min:1'],
            'itinerary.*.title' => ['sometimes', 'array'],
            'itinerary.*.title.ar' => ['sometimes', 'string', 'max:255'],
            'itinerary.*.title.en' => ['nullable', 'string', 'max:255'],
            'itinerary.*.description' => ['nullable', 'array'],
            'itinerary.*.description.ar' => ['nullable', 'string'],
            'itinerary.*.description.en' => ['nullable', 'string'],

            'cover_image' => ['sometimes', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'attachments' => ['nullable', 'array'],
            'attachments.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'departure_at' => ['sometimes', 'date', 'after:now'],
            'return_at' => [
                'nullable',
                'date',
                'after:departure_at',
            ],
            'duration_days' => ['sometimes', 'integer', 'min:1', 'max:365'],
            'duration_nights' => ['sometimes', 'integer', 'min:0', 'max:364'],
            'price' => ['sometimes', 'numeric', 'min:0', 'decimal:0,3'],
//            'currency' => ['required', 'string', 'size:3'],

            'available_seats' => ['required', 'integer', 'min:1'],
            'booked_seats' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
