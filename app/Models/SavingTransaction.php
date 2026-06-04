<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;


class SavingTransaction extends Model
{
    use HasFactory;

    protected $table = 'savings_transactions';

    protected $fillable = [
        'user_id',
        'savings_id',
        'wallet_id',
        'amount',
        'type',
        'transaction_date',
        'description',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'transaction_date' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function savingAccount()
    {
        return $this->belongsTo(Saving::class, 'savings_id');
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
}
