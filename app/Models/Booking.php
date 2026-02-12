<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'gym_id',
        'training_session_id',
        'member_id',
        'status',
        'notes',
    ];

    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }

    public function session()
    {
        return $this->belongsTo(TrainingSession::class, 'training_session_id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
