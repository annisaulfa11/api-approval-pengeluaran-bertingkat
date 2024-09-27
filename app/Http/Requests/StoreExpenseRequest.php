<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExpenseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'amount' => 'required|integer|min:1', 
        ];
    }

    public function messages()
    {
        return [
            'amount.required' => 'Jumlah pengeluaran harus diisi.',
            'amount.integer' => 'Jumlah pengeluaran harus berupa angka.',
            'amount.min' => 'Jumlah pengeluaran minimal adalah 1.',
        ];
    }
}
