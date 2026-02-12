<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'gym_id',
        'title',
        'amount',
        'expense_date',
        'category',
        'notes',
        'attachment_path',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'expense_date' => 'date',
    ];

    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }
}
