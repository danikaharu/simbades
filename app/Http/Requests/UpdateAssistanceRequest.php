<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAssistanceRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'alias' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama Bantuan Wajib Diisi',
            'name.string' => 'Nama Bantuan Hanya Angka dan Huruf',
            'name.max' => 'Nama Bantuan Maksimal 255 Kata',
            'alias.required' => 'Singkatan Bantuan Wajib Diisi',
            'alias.string' => 'Singkatan Bantuan Hanya Angka dan Huruf',
            'alias.max' => 'Singkatan Bantuan Maksimal 255 Kata',
        ];
    }
}
