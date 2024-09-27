<?php
namespace App\Repositories\Interfaces;

interface ExpenseRepository
{
    public function create(array $data);
    public function find($id);
    public function approve($id, $approverId);
}
