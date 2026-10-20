<?php

namespace App\Http\Requests\Front\Orders;

use App\Enums\PaymentTypeEnum;
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
            'trip_id' => 'required|exists:trips,id',
            Rule::in([
                TripTypeEnum::UMRAH,
                TripTypeEnum::HAJJ,
                TripTypeEnum::EVENTS,
                TripTypeEnum::OUTBOUND,
                TripTypeEnum::HONEYMOON,
            ]),
            'number_of_pilgrims' => 'required|integer|min:1',
            'departure_at' => ['required', 'date', 'after:now'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'nationality' => ['required', 'string'],
            'notes' => ['nullable', 'string'],
            'payment_type' => ['required', Rule::in([
                PaymentTypeEnum::COD,
                PaymentTypeEnum::VISA,
                PaymentTypeEnum::KNET
            ])]
        ];
    }
}
