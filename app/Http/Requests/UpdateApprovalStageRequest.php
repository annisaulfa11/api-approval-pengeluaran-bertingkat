<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateApprovalStageRequest extends FormRequest
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
        $approvalStageId = $this->route('id');

        return [
            'approver_id' => [
                'required',
                'exists:approvers,id',
                'unique:approval_stages,approver_id,' . $approvalStageId 
            ],
        ];
    }

    public function messages()
    {
        return [
            'approver_id.required' => 'ID approver harus diisi.',
            'approver_id.exists' => 'ID approver tidak ditemukan di tabel approvers.',
            'approver_id.unique' => 'Approver ini sudah digunakan di tahap approval lain.',
        ];
    }
}
