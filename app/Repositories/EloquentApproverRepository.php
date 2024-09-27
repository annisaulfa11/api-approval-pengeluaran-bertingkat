<?php
namespace App\Repositories;

use App\Models\Approver;
use App\Repositories\Interfaces\ApproverRepository;
use Illuminate\Support\Facades\DB;


class EloquentApproverRepository implements ApproverRepository
{
    protected $model;

    public function __construct(Approver $approver)
    {
        $this->model = $approver;
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
            $approver = $this->model->create($data);
            DB::commit();
            return $approver;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

}
