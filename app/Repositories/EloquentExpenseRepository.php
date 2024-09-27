<?php
namespace App\Repositories;

use App\Models\Expense;
use App\Models\Approval;
use App\Models\Status;
use App\Models\ApprovalStage;
use App\Repositories\Interfaces\ExpenseRepository;
use Illuminate\Support\Facades\DB;



class EloquentExpenseRepository implements ExpenseRepository
{
    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $status = Status::where('name', 'menunggu persetujuan')->first();
            $data['status_id'] = $status->id;
            $expense = Expense::create($data);
            $approvalStages = ApprovalStage::orderBy('id', 'asc')->get();

            foreach ($approvalStages as $stage) {
                Approval::create([
                    'expense_id' => $expense->id,
                    'approver_id' => $stage->approver_id,
                    'status_id' => $status->id // Status awal: menunggu persetujuan
                ]);
            }
            DB::commit();

            return $expense;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

    }

    public function find($id)
    {
        return Expense::with(['status', 'approvals.approver', 'approvals.status'])->findOrFail($id);
    }

    public function approve($id, $approverId)
    {
        DB::beginTransaction();
        try {

            $expense = Expense::findOrFail($id);
            $status1 = Status::where('name', 'menunggu persetujuan')->first();
            $status2 = Status::where('name', 'disetujui')->first();

            $currentApprovalStage = ApprovalStage::join('approvals', 'approvals.approver_id', '=', 'approval_stages.approver_id')
                ->where('approvals.expense_id', $id)
                ->where('approvals.status_id', $status1->id) // Status menunggu persetujuan
                ->orderBy('approval_stages.id', 'asc')
                ->first();

            if (!$currentApprovalStage || $currentApprovalStage->approver_id != $approverId) {
                return response()->json(['message' => 'Anda tidak dapat melakukan approval pada tahap ini.'], 400);
            }

            $currentApproval = Approval::where('expense_id', $id)
                ->where('approver_id', $approverId)
                ->first();
            $currentApproval->update(['status_id' => $status2->id]); // Status disetujui

            $remainingApprovalStages = Approval::where('expense_id', $id)
                ->where('status_id', $status1->id)
                ->count();

            if ($remainingApprovalStages == 0) {
                $expense->update(['status_id' => $status2->id]); // Status disetujui
            }
            DB::commit();

            return response()->json(['message' => 'Approval berhasil.']);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
