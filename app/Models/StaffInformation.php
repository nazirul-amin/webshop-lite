<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StaffInformation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'staff_informations';
    protected $guarded = ['id'];

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id')->withTrashed();
    }

    public function attendance(){
        return $this->hasMany(Attendance::class, 'staff_id', 'id');
    }
}
