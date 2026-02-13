<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'gym_id',
        'order_id',
        'product_id',
        'quantity',
        'unit_price',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }
}
