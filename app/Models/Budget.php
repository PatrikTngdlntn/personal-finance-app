<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Category;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'limit_amount',
        'period',
    ];

    protected $casts = [
        'limit_amount' => 'decimal:2',
    ];

    // Budget milik user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Budget untuk kategori tertentu
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
