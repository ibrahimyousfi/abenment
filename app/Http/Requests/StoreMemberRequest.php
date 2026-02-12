<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'cin' => ['required', 'string', 'max:20', 'unique:members,cin'],
            'gender' => ['required', 'in:male,female'],
            'photo' => ['nullable', 'image', 'max:2048'],
            
            // Subscription Validation
            'plan_id' => ['required', 'exists:plans,id'],
            'start_date' => ['required', 'date'],
            'payment_method' => ['required', 'in:cash,card,transfer'],
        ];
    }
}
