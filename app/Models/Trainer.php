<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    use HasFactory;

    protected $fillable = [
        'gym_id',
        'full_name',
        'specialization',
        'phone',
        'email',
        'photo_path',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }

    public function sessions()
    {
        return $this->hasMany(TrainingSession::class);
    }
}
