<?php

namespace App\Http\Requests\Front\ContactMessages;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

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
            'name' => ['required', 'string', 'min:2', 'max:150'],
            'phone' => ['required', 'string', 'max:30'],
            'email' => ['required', 'string', 'email' ,'max:30'],
            'message' => ['required', 'string', 'min:5', 'max:5000'],
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'الاسم مطلوب.',
            'name.min' => 'الاسم يجب أن يكون حرفين على الأقل.',
            'phone.required' => 'رقم الهاتف مطلوب.',
//            'phone.regex' => 'صيغة رقم الهاتف غير صحيحة.',
            'message.required' => 'الرسالة مطلوبة.',
            'message.min' => 'الرسالة يجب أن تكون 5 أحرف على الأقل.',
        ];
    }
}
