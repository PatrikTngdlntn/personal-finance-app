<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Category;
use App\Models\Receipt;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'wallet_id',
        'category_id',
        'amount',
        'type',
        'date',
        'description',
        'transaction_date'
    ];

    // user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // wallet
    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    // category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // receipt
    public function receipts()
    {
        return $this->hasMany(Receipt::class);
    }
}
