<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Saving extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'target_amount',
        'saved_amount',
        'target_date'
    ];

    // user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
