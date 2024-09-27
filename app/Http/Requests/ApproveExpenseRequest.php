<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\ApprovalStage;
use App\Models\Approval;

class ApproveExpenseRequest extends FormRequest
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
            'approver_id' => 'required|exists:approvers,id',
        ];
    }

    public function messages()
    {
        return [
            'approver_id.required' => 'ID approver harus diisi.',
            'approver_id.exists'   => 'Approver dengan ID tersebut tidak ditemukan.',
        ];
    }

}
