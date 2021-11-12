<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function approver()
    {
        return $this->hasOne(StaffInformation::class, 'user_id', 'approver_id');
    }

    public function staff()
    {
        return $this->hasOne(StaffInformation::class, 'user_id', 'staff_id');
    }
}
