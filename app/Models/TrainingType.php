<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingType extends Model
{
    protected $fillable = [
        'gym_id',
        'name',
        'description',
    ];

    public function plans()
    {
        return $this->hasMany(Plan::class);
    }

    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }
}
