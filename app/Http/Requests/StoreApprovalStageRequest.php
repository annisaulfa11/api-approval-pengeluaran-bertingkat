<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApprovalStageRequest extends FormRequest
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
            'approver_id' => 'required|exists:approvers,id|unique:approval_stages,approver_id',
        ];
    }
    public function messages()
    {
        return [
            'approver_id.required' => 'ID approver harus diisi.',
            'approver_id.exists' => 'ID approver tidak ditemukan.',
            'approver_id.unique' => 'Approver ini sudah ada di tahap approval.',
        ];
    }
}
