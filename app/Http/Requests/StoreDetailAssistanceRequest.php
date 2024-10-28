<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDetailAssistanceRequest extends FormRequest
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
            'assistance_id' => 'required|exists:assistances,id',
            'input_date' => 'required|date',
            'type' => 'required|in:1,2',
            'additional_data.nominal' => 'required_if:type,1',
            'additional_data.nama_barang' => 'required_if:type,2|array',
            'additional_data.nama_barang.*' => 'required_if:type,2', // Validasi untuk setiap nama barang
            'additional_data.jumlah_barang' => 'required_if:type,2|array',
            'additional_data.jumlah_barang.*' => 'required_if:type,2', // Validasi untuk setiap jumlah barang
        ];
    }
}
