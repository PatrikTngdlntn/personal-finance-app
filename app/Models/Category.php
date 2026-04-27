<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Budget;

class Category extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'name',
        'type'
    ];

    protected $casts = [
        'type' => 'string',
    ];

    // Category milik user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Category digunakan di transaksi
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // Category digunakan di budget
    public function budgets()
    {
        return $this->hasMany(Budget::class);
    }
}
