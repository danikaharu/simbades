<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class StoreRecipientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        return $this->merge([
            'status' => 0
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'person_id' => ['required', 'exists:persons,id'],
            'assistance_id' => ['required', 'exists:assistances,id'],
            'year' => ['required', 'integer'],
            'status' => ['in:0'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $exists = DB::table('recipients')
                ->where('year', $this->year)
                ->where('person_id', $this->person_id)
                ->where('assistance_id', $this->assistance_id)
                ->exists();

            if ($exists) {
                $validator->errors()->add('assistance_id', 'Masyarakat sudah terdaftar di bantuan ini');
            }
        });
    }
}
