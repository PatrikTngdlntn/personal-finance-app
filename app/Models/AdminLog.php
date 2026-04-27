<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\User;

class AdminLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'admin_id',
        'target_user_id',
        'action',
        'description',
        'metadata'
    ];
    protected $casts = [
        'metadata' => 'array',
    ];

    // Admin (yang melakukan aksi)
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    // Target user (yang dikenai aksi)
    public function targetUser()
    {
        return $this->belongsTo(User::class, 'target_user_id');
    }
}
