<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    protected $table = 'approvals';
    protected $fillable = ['expense_id', 'approver_id', 'status_id'];
    public $timestamps = true;

    public function expense()
    {
        return $this->belongsTo(Expense::class);
    }

    public function approver()
    {
        return $this->belongsTo(Approver::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}

