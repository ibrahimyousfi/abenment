<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'gym_id',
        'member_id',
        'invoice_number',
        'issue_date',
        'due_date',
        'total_amount',
        'paid_amount',
        'status',
        'type',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'due_date' => 'date',
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
    ];

    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function getBalanceAttribute()
    {
        return $this->total_amount - $this->paid_amount;
    }
}
