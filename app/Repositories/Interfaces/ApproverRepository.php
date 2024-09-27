<?php

namespace App\Repositories\Interfaces;

interface ApproverRepository
{
    public function all();
    public function find($id);
    public function create(array $data);

}
