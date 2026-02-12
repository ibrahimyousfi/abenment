<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gym extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'logo',
        'subscription_expires_at',
        'is_active',
    ];

    protected $casts = [
        'subscription_expires_at' => 'date',
        'is_active' => 'boolean',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function trainingTypes()
    {
        return $this->hasMany(TrainingType::class);
    }

    public function plans()
    {
        return $this->hasMany(Plan::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function trainers()
    {
        return $this->hasMany(Trainer::class);
    }

    public function trainingSessions()
    {
        return $this->hasMany(TrainingSession::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function equipment()
    {
        return $this->hasMany(Equipment::class);
    }

    public function maintenanceLogs()
    {
        return $this->hasMany(MaintenanceLog::class);
    }

    public function isSubscriptionExpired()
    {
        return $this->subscription_expires_at && $this->subscription_expires_at < now();
    }

    public function getDaysUntilExpiry()
    {
        if (!$this->subscription_expires_at) {
            return null;
        }

        return now()->diffInDays($this->subscription_expires_at, false);
    }
}
