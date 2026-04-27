<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Subscription extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
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
}
