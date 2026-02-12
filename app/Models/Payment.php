<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'gym_id',
        'invoice_id',
        'member_id',
        'amount',
        'payment_method',
        'payment_date',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
    ];

    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
