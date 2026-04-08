<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Transfer;

class Wallet extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'balance',
        'type'
    ];

    // user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // transactions
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // transfers keluar
    public function transfersFrom()
    {
        return $this->hasMany(Transfer::class, 'from_wallet_id');
    }
    // transfers masuk
    public function transfersTo()
    {
        return $this->hasMany(Transfer::class, 'to_wallet_id');
    }
}
