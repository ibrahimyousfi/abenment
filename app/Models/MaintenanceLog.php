<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'gym_id',
        'equipment_id',
        'title',
        'description',
        'cost',
        'maintenance_date',
        'next_maintenance_date',
        'status',
        'performed_by',
    ];

    protected $casts = [
        'maintenance_date' => 'date',
        'next_maintenance_date' => 'date',
        'cost' => 'decimal:2',
    ];

    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }
}
