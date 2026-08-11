<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'asset_category_id',
        'is_active',
    ];

    public function assetCategory()
    {
        return $this->belongsTo(AssetCategory::class);
    }
}
