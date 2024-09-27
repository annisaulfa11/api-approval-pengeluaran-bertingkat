<?php
namespace App\Repositories;

use App\Models\ApprovalStage;
use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\ApprovalStageRepository;


class EloquentApprovalStageRepository implements ApprovalStageRepository
{
    protected $model;

    public function __construct(ApprovalStage $approvalStage)
    {
        $this->model = $approvalStage;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $approvalStage = $this->model->create($data);
            DB::commit();
            return $approvalStage;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

    }

    public function update($id, array $data)
    {
        DB::beginTransaction();
        try {
            $approvalStage = $this->find($id);
            $approvalStage->update($data);
            DB::commit();
            return $approvalStage;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

    }

}
