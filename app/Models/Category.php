<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Transaction;

class Category extends Model
{
    protected $fillable = [
        'user_id',
        'name',
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
}
