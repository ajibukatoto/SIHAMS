<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetMaintenance extends Model
{
    protected $fillable = [
        'asset_id',
        'reported_by',
        'maintenance_type',
        'problem_description',
        'maintenance_date',
        'completion_date',
        'status',
        'technician',
        'cost',
        'remarks',
    ];

    protected $casts = [
        'maintenance_date' => 'date',
        'completion_date' => 'date',
        'cost' => 'decimal:2',
    ];


    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }


    public function reportedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reported_by');
    }
}

