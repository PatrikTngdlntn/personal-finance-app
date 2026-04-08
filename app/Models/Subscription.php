<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Subscription extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'amount',
        'billing_cycle',
        'next_billing'
    ];

    //  ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
