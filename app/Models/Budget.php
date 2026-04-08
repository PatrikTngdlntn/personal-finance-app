<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Category;

class Budget extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'amount_limit',
        'period',
        'start_date',
        'end_date'
    ];

    // user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
