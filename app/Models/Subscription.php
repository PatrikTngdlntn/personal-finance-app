<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Wallet;

class Subscription extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'wallet_id',
        'name',
        'amount',
        'currency',
        'billing_cycle',
        'next_billing',
    ];
    protected $casts = [
        'amount' => 'decimal:2',
        'next_billing' => 'date',
    ];

    // Subscription milik user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    // =========================
    // CEK SUBSCRIPTION JATUH TEMPO
    // =========================
    public function isDue()
    {
        return $this->next_billing->isPast()
            || $this->next_billing->isToday();
    }

    // =========================
    // FORMAT BILLING CYCLE
    // =========================
    public function billingCycleLabel()
    {
        return match ($this->billing_cycle) {
            'daily' => 'Harian',
            'weekly' => 'Mingguan',
            'monthly' => 'Bulanan',
            'yearly' => 'Tahunan',
            default => ucfirst($this->billing_cycle),
        };
    }
}
