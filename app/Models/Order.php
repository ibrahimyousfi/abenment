<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'gym_id',
        'user_id',
        'client_name',
        'total_amount',
        'discount_amount',
        'tax_amount',
        'payment_method',
        'status',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }

    public function cashier()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
