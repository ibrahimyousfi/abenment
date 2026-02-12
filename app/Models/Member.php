<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Member extends Model
{
    use Notifiable;

    protected $fillable = [
        'gym_id',
        'full_name',
        'phone',
        'email',
        'cin',
        'gender',
        'photo_path',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Status Logic
    |--------------------------------------------------------------------------
    */

    public function getStatusAttribute()
    {
        $today = now()->toDateString();

        // If has valid active subscription (ends today or in the future)
        if ($this->subscriptions()->where('end_date', '>=', $today)->exists()) {
            return 'Active';
        }

        // If has expired subscription (ended before today, and no future one)
        if ($this->subscriptions()->where('end_date', '<', $today)->exists()) {
            return 'Expired';
        }

        // If no subscriptions at all
        return 'Inactive';
    }

    public function scopeActive($query)
    {
        return $query->whereHas('subscriptions', function ($q) {
            $q->where('end_date', '>=', now()->toDateString());
        });
    }

    public function scopeExpired($query)
    {
        return $query->whereHas('subscriptions', function ($q) {
            $q->where('end_date', '<', now()->toDateString());
        })->whereDoesntHave('subscriptions', function ($q) {
            $q->where('end_date', '>=', now()->toDateString());
        });
    }

    public function scopeInactive($query)
    {
        return $query->doesntHave('subscriptions');
    }
}
