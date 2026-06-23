<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionHistory extends Model
{
    protected $fillable = [
        'subscription_id',
        'user_id',
        'wallet_id',
        'subscription_name',
        'amount',
        'currency',
        'paid_at',
    ];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
}
