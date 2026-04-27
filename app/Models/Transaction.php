<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Category;
use App\Models\Receipt;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'wallet_id',
        'category_id',
        'transfer_to_wallet_id',
        'amount',
        'type',
        'description',
        'transaction_date'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'transaction_date' => 'date',
    ];

    // milik user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // wallet asal
    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    // kategori (nullable)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // wallet tujuan (khusus transfer)
    public function transferToWallet()
    {
        return $this->belongsTo(Wallet::class, 'transfer_to_wallet_id');
    }

    // bukti transaksi
    public function receipts()
    {
        return $this->hasMany(Receipt::class);
    }
}
