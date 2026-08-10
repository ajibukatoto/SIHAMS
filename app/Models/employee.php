<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class employee extends Model
{
    protected $fillable = [
        'employee_no',
        'full_name',
        'email',
        'phone_number',
        'department_id',
        'office_id',
        'job_title',
        'profile_photo',
        'employment_date',
        'is_active',
    ];
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function office()
    {
        return $this->belongsTo(Office::class);
    }
}
