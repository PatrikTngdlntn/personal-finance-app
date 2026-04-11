<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Wallet;

class Transfer extends Model
{
    protected $fillable = [
        'user_id',
        'from_wallet_id',
        'to_wallet_id',
        'amount',
        'description',
        'transfer_date'
    ];

    // ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //  wallet asal
    public function fromWallet()
    {
        return $this->belongsTo(Wallet::class, 'from_wallet_id');
    }

    //  wallet tujuan
    public function toWallet()
    {
        return $this->belongsTo(Wallet::class, 'to_wallet_id');
    }
}
