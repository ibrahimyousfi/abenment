<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'gym_id',
        'name',
        'brand',
        'model',
        'purchase_date',
        'price',
        'status',
        'warranty_expiry',
        'photo_path',
        'notes',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'warranty_expiry' => 'date',
        'price' => 'decimal:2',
    ];

    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }

    public function maintenanceLogs()
    {
        return $this->hasMany(MaintenanceLog::class);
    }
}
