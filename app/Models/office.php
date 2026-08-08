<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class office extends Model
{
    protected $fillable = [
        'department_id',
        'office_name',
        'region',
        'district',
        'address',
        'is_active',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }   
}
