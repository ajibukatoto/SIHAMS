<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Asset;



class AssetCategory extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'is_active',
    ];
    public function assets()
    {
        return $this->hasMany(Asset::class);

    }
}

