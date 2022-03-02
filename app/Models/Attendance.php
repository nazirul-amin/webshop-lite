<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function staff(){
        return $this->hasOne(StaffInformation::class, 'id', 'staff_id')->withTrashed();
    }
}
