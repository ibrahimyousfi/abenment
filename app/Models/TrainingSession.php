<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'gym_id',
        'training_type_id',
        'trainer_id',
        'name',
        'start_time',
        'end_time',
        'capacity',
        'status',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }

    public function trainingType()
    {
        return $this->belongsTo(TrainingType::class);
    }

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function confirmedBookings()
    {
        return $this->bookings()->where('status', 'confirmed');
    }

    public function getIsFullAttribute()
    {
        return $this->confirmedBookings()->count() >= $this->capacity;
    }
}
