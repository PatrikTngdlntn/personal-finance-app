<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Transaction;


class Wallet extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'name',
        'type',
        'currency',
        'initial_balance',
    ];

    protected $casts = [
        'initial_balance' => 'decimal:2',
    ];

    // Wallet milik user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Transaksi keluar/masuk dari wallet
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // Transaksi transfer MASUK 
    public function incomingTransfers()
    {
        return $this->hasMany(Transaction::class, 'transfer_to_wallet_id');
    }

    public function getBalanceAttribute()
    {
        // income
        $income = Transaction::where('wallet_id', $this->id)
            ->where('type', 'income')
            ->sum('amount');

        // expense
        $expense = Transaction::where('wallet_id', $this->id)
            ->where('type', 'expense')
            ->sum('amount');

        // transfer keluar
        $transferOut = Transaction::where('wallet_id', $this->id)
            ->where('type', 'transfer')
            ->sum('amount');

        // transfer masuk
        $transferIn = Transaction::where('transfer_to_wallet_id', $this->id)
            ->where('type', 'transfer')
            ->sum('amount');

        return
            $this->initial_balance
            + $income
            - $expense
            - $transferOut
            + $transferIn;
    }
}
