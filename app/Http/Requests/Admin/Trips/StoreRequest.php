<?php

namespace App\Http\Requests\Admin\Trips;

use App\Enums\TripTypeEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
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
                'required',
                'string',
                Rule::in([
                    TripTypeEnum::UMRAH,
                    TripTypeEnum::HAJJ,
                    TripTypeEnum::EVENTS,
                    TripTypeEnum::OUTBOUND,
                    TripTypeEnum::HONEYMOON,
                ]),
            ],
            'title' => ['required', 'array'],
            'title.ar' => ['required', 'string', 'max:255'],
            'title.en' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'array'],
            'description.ar' => ['nullable', 'string'],
            'description.en' => ['nullable', 'string'],

            'includes' => ['required', 'array'],
            'includes.ar' => ['required', 'string', 'max:255'],
            'includes.en' => ['nullable', 'string', 'max:255'],
            'excludes' => ['required', 'array'],
            'excludes.ar' => ['required', 'string', 'max:255'],
            'excludes.en' => ['nullable', 'string', 'max:255'],
            'hotel_name' => ['required', 'array'],
            'hotel_name.ar' => ['required', 'string', 'max:255'],
            'hotel_name.en' => ['nullable', 'string', 'max:255'],
            'itinerary' => ['nullable', 'array', 'max:60'],
            'itinerary.*.day' => ['required', 'integer', 'min:1'],
            'itinerary.*.title' => ['required', 'array'],
            'itinerary.*.title.ar' => ['required', 'string', 'max:255'],
            'itinerary.*.title.en' => ['nullable', 'string', 'max:255'],
            'itinerary.*.description' => ['nullable', 'array'],
            'itinerary.*.description.ar' => ['nullable', 'string'],
            'itinerary.*.description.en' => ['nullable', 'string'],

            'cover_image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'attachments' => ['nullable', 'array'],
            'attachments.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'departure_at' => ['required', 'date', 'after:now'],
            'return_at' => [
                'nullable',
                'date',
                'after:departure_at',
            ],
            'duration_days' => ['required', 'integer', 'min:1', 'max:365'],
            'duration_nights' => ['required', 'integer', 'min:0', 'max:364'],
            'price' => ['required', 'numeric', 'min:0', 'decimal:0,3'],
            'price_after_discount' => [
                'nullable',
                'numeric',
                'gt:0',
                'lt:price',
                'decimal:0,3',
            ],

            'offer_starts_at' => [
                'nullable',
                'date',
                'after_or_equal:now',
                'required_with:offer_ends_at',
            ],

            'offer_ends_at' => [
                'nullable',
                'date',
                'after:offer_starts_at',
                'required_with:offer_starts_at',
                'required_with:discount_price',
            ],

            'available_seats' => ['required', 'integer', 'min:1'],
            'booked_seats' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
