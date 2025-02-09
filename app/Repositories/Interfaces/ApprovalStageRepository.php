<?php
namespace App\Repositories\Interfaces;

interface ApprovalStageRepository
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);

}
