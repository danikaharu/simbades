<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePersonRequest extends FormRequest
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
            'village_id' => ['required', 'exists:villages,id'],
            'family_card' => ['required', 'numeric', 'max_digits:16'],
            'identification_number' => ['required', 'numeric', 'max_digits:16'],
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'in:1,2'],
            'birth_place' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date'],
            'religion' => ['required', 'in:1,2,3,4,5'],
            'kinship' => ['required', 'in:1,2,3,4,5,6'],
            'father_name' => ['required', 'string', 'max:255'],
            'mother_name' => ['required', 'string', 'max:255'],
            'last_education' => ['required', 'in:1,2,3,4,5,6,7,8,9'],
            'work' => ['required', 'string', 'max:255'],
            'income_month' => ['required', 'string', 'max:255'],
        ];
    }
}
