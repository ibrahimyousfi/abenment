<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'gym_id',
        'name',
        'training_type_id',
        'duration_days',
        'price',
        'is_active',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function trainingType()
    {
        return $this->belongsTo(TrainingType::class);
    }

    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }
}
