<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\SavingTransaction;

class Saving extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'target_amount',
        'saved_amount',
        'target_date'
    ];

    protected $casts = [
        'target_amount' => 'decimal:2',
        'saved_amount' => 'decimal:2',
        'target_date' => 'date',
    ];

    // Saving milik user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Riwayat setoran / penarikan
    public function transactions()
    {
        // FK eksplisit karena kolom di DB adalah 'savings_id' (plural),
        // bukan 'saving_id' yang jadi default Laravel
        return $this->hasMany(SavingTransaction::class, 'savings_id');
    }
}
