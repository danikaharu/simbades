<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'village_name' => ['required', 'string', 'max:255'],
            'village_logo' => ['nullable', 'mimes:jpg,jpeg,png,svg', 'max:2048'],
            'address' => ['required'],
            'whatsapp_number' => ['required', 'numeric']
        ];
    }
}
