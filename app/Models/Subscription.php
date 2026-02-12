<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'gym_id',
        'member_id',
        'plan_id',
        'start_date',
        'end_date',
        'price_snapshot',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }

    public function scopeActive($query)
    {
        return $query->where('end_date', '>=', now()->toDateString());
    }
}
