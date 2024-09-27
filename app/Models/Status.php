<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'statuses';
    protected $fillable = ['name'];
    public $timestamps = false;
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
