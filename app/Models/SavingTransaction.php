<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\Saving;

class SavingTransaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'savings_id',
        'amount',
        'type',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public $timestamps = true;

    // ke saving account
    // Saving milik user
    // transaksi ini milik saving account
    public function savingAccount()
    {
        return $this->belongsTo(Saving::class, 'savings_id');
    }
}
