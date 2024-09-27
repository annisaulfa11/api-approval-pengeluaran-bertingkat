<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApproverRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:approvers,name',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama approver harus diisi.',
            'name.string' => 'Nama approver harus berupa string.',
            'name.unique' => 'Nama approver sudah ada.',
        ];
    }
}
